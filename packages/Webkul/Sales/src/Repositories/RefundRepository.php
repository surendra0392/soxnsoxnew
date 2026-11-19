<?php

namespace Webkul\Sales\Repositories;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Eloquent\Repository;
use Webkul\Sales\Contracts\Refund;
use Webkul\Sales\Exceptions\InvalidRefundQuantityException;

class RefundRepository extends Repository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected OrderItemRepository $orderItemRepository,
        protected RefundItemRepository $refundItemRepository,
        protected DownloadableLinkPurchasedRepository $downloadableLinkPurchasedRepository,
        Container $container
    ) {
        parent::__construct($container);
    }

    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return 'Webkul\Sales\Contracts\Refund';
    }

    /**
     * Create refund.
     *
     * @return Refund
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            Event::dispatch('sales.refund.save.before', $data);

            $order = $this->orderRepository->findOrFail($data['order_id']);

            $totalQty = array_sum($data['refund']['items'] ?? []) ?? 0;

            $adjustmentRefund = (float) (($data['refund']['adjustment_refund'] ?? 0) ?: 0);
            $adjustmentFee = (float) (($data['refund']['adjustment_fee'] ?? 0) ?: 0);
            $shippingAmount = (float) (($data['refund']['shipping'] ?? 0) ?: 0);

            $refund = parent::create([
                'order_id' => $order->id,
                'total_qty' => $totalQty,
                'state' => 'refunded',
                'base_currency_code' => $order->base_currency_code,
                'channel_currency_code' => $order->channel_currency_code,
                'order_currency_code' => $order->order_currency_code,
                'adjustment_refund' => core()->convertPrice($adjustmentRefund, $order->order_currency_code),
                'base_adjustment_refund' => $adjustmentRefund,
                'adjustment_fee' => core()->convertPrice($adjustmentFee, $order->order_currency_code),
                'base_adjustment_fee' => $adjustmentFee,
                'shipping_amount' => core()->convertPrice($shippingAmount, $order->order_currency_code),
                'base_shipping_amount' => $shippingAmount,
            ]);

            foreach ($data['refund']['items'] ?? [] as $itemId => $qty) {
                if (! $qty) {
                    continue;
                }

                $orderItem = $this->orderItemRepository->findOneWhere([
                    'id' => $itemId,
                    'order_id' => $order->id,
                ]);

                if (! $orderItem) {
                    throw new InvalidRefundQuantityException(trans('admin::app.sales.refunds.create.invalid-qty'));
                }

                if ($qty > $orderItem->qty_to_refund) {
                    $qty = $orderItem->qty_to_refund;
                }

                $taxAmount = $orderItem->qty_ordered > 0
                    ? (($orderItem->tax_amount / $orderItem->qty_ordered) * $qty)
                    : 0;

                $baseTaxAmount = $orderItem->qty_ordered > 0
                    ? (($orderItem->base_tax_amount / $orderItem->qty_ordered) * $qty)
                    : 0;

                $refundItem = $this->refundItemRepository->create([
                    'refund_id' => $refund->id,
                    'order_item_id' => $orderItem->id,
                    'name' => $orderItem->name,
                    'sku' => $orderItem->sku,
                    'qty' => $qty,
                    'price' => $orderItem->price,
                    'price_incl_tax' => $orderItem->price_incl_tax,
                    'base_price' => $orderItem->base_price,
                    'base_price_incl_tax' => $orderItem->base_price_incl_tax,
                    'total' => $orderItem->price * $qty,
                    'total_incl_tax' => ($orderItem->price * $qty) + $taxAmount,
                    'base_total' => $orderItem->base_price * $qty,
                    'base_total_incl_tax' => ($orderItem->base_price * $qty) + $baseTaxAmount,
                    'tax_amount' => $taxAmount,
                    'base_tax_amount' => $baseTaxAmount,
                    'discount_amount' => $orderItem->qty_ordered > 0
                        ? (($orderItem->discount_amount / $orderItem->qty_ordered) * $qty)
                        : 0,
                    'base_discount_amount' => $orderItem->qty_ordered > 0
                        ? (($orderItem->base_discount_amount / $orderItem->qty_ordered) * $qty)
                        : 0,
                    'product_id' => $orderItem->product_id,
                    'product_type' => $orderItem->product_type,
                    'additional' => $orderItem->additional,
                ]);

                if ($orderItem->getTypeInstance()->isComposite()) {
                    foreach ($orderItem->children as $childOrderItem) {
                        $finalQty = ($childOrderItem->qty_ordered && $orderItem->qty_ordered > 0)
                            ? ($childOrderItem->qty_ordered / $orderItem->qty_ordered) * $qty
                            : $orderItem->qty_ordered;

                        $refundItem->child = $this->refundItemRepository->create([
                            'refund_id' => $refund->id,
                            'order_item_id' => $childOrderItem->id,
                            'parent_id' => $refundItem->id,
                            'name' => $childOrderItem->name,
                            'sku' => $childOrderItem->sku,
                            'qty' => $finalQty,
                            'price' => $childOrderItem->price,
                            'base_price' => $childOrderItem->base_price,
                            'total' => $childOrderItem->price * $finalQty,
                            'base_total' => $childOrderItem->base_price * $finalQty,
                            'tax_amount' => 0,
                            'base_tax_amount' => 0,
                            'discount_amount' => 0,
                            'base_discount_amount' => 0,
                            'product_id' => $childOrderItem->product_id,
                            'product_type' => $childOrderItem->product_type,
                            'additional' => $childOrderItem->additional,
                        ]);

                        if (
                            $childOrderItem->getTypeInstance()->isStockable()
                            || $childOrderItem->getTypeInstance()->showQuantityBox()
                        ) {
                            $this->refundItemRepository->returnQtyToProductInventory($childOrderItem, $finalQty);
                        }

                        $this->orderItemRepository->collectTotals($childOrderItem);
                    }

                } else {
                    if (
                        $orderItem->getTypeInstance()->isStockable()
                        || $orderItem->getTypeInstance()->showQuantityBox()
                    ) {
                        $this->refundItemRepository->returnQtyToProductInventory($orderItem, $qty);
                    }
                }

                $this->orderItemRepository->collectTotals($orderItem);

                if ($orderItem->qty_ordered == $orderItem->qty_refunded + $orderItem->qty_canceled) {
                    $this->downloadableLinkPurchasedRepository->updateStatus($orderItem, 'expired');
                }
            }

            $this->collectTotals($refund);

            $this->orderRepository->collectTotals($order);

            $this->orderRepository->updateOrderStatus($order);

            Event::dispatch('sales.refund.save.after', $refund);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return $refund;
    }

    /**
     * Collect totals.
     *
     * @param  Refund  $refund
     * @return Refund
     */
    public function collectTotals($refund)
    {
        $refund->sub_total = $refund->base_sub_total = 0;
        $refund->sub_total_incl_tax = $refund->base_sub_total_incl_tax = 0;
        $refund->tax_amount = $refund->base_tax_amount = 0;
        $refund->shipping_tax_amount = $refund->base_shipping_tax_amount = 0;
        $refund->discount_amount = $refund->base_discount_amount = 0;

        foreach ($refund->items as $item) {
            $refund->tax_amount += $item->tax_amount;
            $refund->base_tax_amount += $item->base_tax_amount;

            $refund->discount_amount += $item->discount_amount;
            $refund->base_discount_amount += $item->base_discount_amount;

            $refund->sub_total += $item->total;
            $refund->base_sub_total += $item->base_total;

            $refund->sub_total_incl_tax = (float) $refund->sub_total_incl_tax + $item->total_incl_tax;
            $refund->base_sub_total_incl_tax = (float) $refund->base_sub_total_incl_tax + $item->base_total_incl_tax;
        }

        if ((float) $refund->order->shipping_invoiced) {
            $refund->shipping_tax_amount = ($refund->order->shipping_tax_amount / $refund->order->shipping_invoiced) * $refund->shipping_amount;
            $refund->base_shipping_tax_amount = ($refund->order->base_shipping_tax_amount / $refund->order->base_shipping_invoiced) * $refund->base_shipping_amount;
        }

        $refund->shipping_amount_incl_tax = $refund->shipping_amount + $refund->shipping_tax_amount;
        $refund->base_shipping_amount_incl_tax = $refund->base_shipping_amount + $refund->base_shipping_tax_amount;

        $refund->tax_amount += $refund->shipping_tax_amount;
        $refund->base_tax_amount += $refund->base_shipping_tax_amount;

        $refund->grand_total = $refund->sub_total + $refund->tax_amount + $refund->shipping_amount + $refund->adjustment_refund - $refund->adjustment_fee - $refund->discount_amount;
        $refund->base_grand_total = $refund->base_sub_total + $refund->base_tax_amount + $refund->base_shipping_amount + $refund->base_adjustment_refund - $refund->base_adjustment_fee - $refund->base_discount_amount;

        $refund->save();

        return $refund;
    }

    /**
     * Get order items refund summary.
     *
     * @param  array  $data
     * @param  int  $orderId
     * @return array|\Exception
     */
    public function getOrderItemsRefundSummary($data, $orderId)
    {
        $order = $this->orderRepository->find($orderId);

        $totals = [
            'subtotal' => ['price' => 0],
            'discount' => ['price' => 0],
            'tax' => ['price' => 0],
            'shipping' => ['price' => 0],
            'grand_total' => ['price' => 0],
        ];

        $shipping = (float) (($data['shipping'] ?? 0) ?: 0);
        $adjustmentRefund = (float) (($data['adjustment_refund'] ?? 0) ?: 0);
        $adjustmentFee = (float) (($data['adjustment_fee'] ?? 0) ?: 0);

        foreach ($data['items'] ?? [] as $orderItemId => $qty) {
            if (! $qty) {
                continue;
            }

            $orderItem = $this->orderItemRepository->findOneWhere([
                'id' => $orderItemId,
                'order_id' => $order->id,
            ]);

            if (! $orderItem || $qty > $orderItem->qty_to_refund) {
                throw new InvalidRefundQuantityException(trans('admin::app.sales.refunds.create.invalid-qty'));
            }

            $totals['subtotal']['price'] += $orderItem->base_price * $qty;

            $totals['discount']['price'] += $orderItem->qty_ordered > 0
                ? ($orderItem->base_discount_amount / $orderItem->qty_ordered) * $qty
                : 0;

            $totals['tax']['price'] += $orderItem->qty_ordered > 0
                ? ($orderItem->base_tax_amount / $orderItem->qty_ordered) * $qty
                : 0;
        }

        if ((float) $order->base_shipping_invoiced) {
            $totals['tax']['price'] += ($order->base_shipping_tax_amount / $order->base_shipping_invoiced) * $shipping;
        }

        $totals['shipping']['price'] += $shipping;

        $totals['grand_total']['price'] += $totals['subtotal']['price'] + $totals['tax']['price'] + $totals['shipping']['price'] + $adjustmentRefund - $adjustmentFee - $totals['discount']['price'];

        $totals = array_map(function ($item) {
            $item['formatted_price'] = core()->formatBasePrice($item['price']);

            return $item;
        }, $totals);

        return $totals;
    }
}
