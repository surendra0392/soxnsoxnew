<?php

namespace Webkul\Attribute\Repositories;

use Illuminate\Http\UploadedFile;
use Webkul\Attribute\Contracts\AttributeOption;
use Webkul\Core\Eloquent\Repository;

class AttributeOptionRepository extends Repository
{
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return 'Webkul\Attribute\Contracts\AttributeOption';
    }

    /**
     * @return AttributeOption
     */
    public function create(array $data)
    {
        $defaultLocale = core()->getDefaultLocaleCodeFromDefaultChannel();

        if (empty($data[$defaultLocale]['label']) && ! empty($data['admin_name'])) {
            $data[$defaultLocale] = array_merge($data[$defaultLocale] ?? [], [
                'label' => $data['admin_name'],
            ]);
        }

        $option = parent::create($data);

        $this->uploadSwatchImage($data, $option->id);

        return $option;
    }

    /**
     * @param  int  $id
     * @return AttributeOption
     */
    public function update(array $data, $id)
    {
        $defaultLocale = core()->getDefaultLocaleCodeFromDefaultChannel();

        if (empty($data[$defaultLocale]['label']) && ! empty($data['admin_name'])) {
            $data[$defaultLocale] = array_merge($data[$defaultLocale] ?? [], [
                'label' => $data['admin_name'],
            ]);
        }

        $option = parent::update($data, $id);

        $this->uploadSwatchImage($data, $id);

        return $option;
    }

    /**
     * @param  array  $data
     * @param  int  $optionId
     * @return void
     */
    public function uploadSwatchImage($data, $optionId)
    {
        if (empty($data['swatch_value'])) {
            return;
        }

        if ($data['swatch_value'] instanceof UploadedFile) {
            parent::update([
                'swatch_value' => $data['swatch_value']->store('attribute_option'),
            ], $optionId);
        }
    }
}
