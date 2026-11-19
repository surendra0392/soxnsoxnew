<?php

namespace Webkul\SocialLogin\Repositories;

use Illuminate\Container\Container;
use Webkul\Core\Eloquent\Repository;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\Customer\Repositories\CustomerRepository;

class CustomerSocialAccountRepository extends Repository
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected CustomerRepository $customerRepository,
        protected CustomerGroupRepository $customerGroupRepository,
        Container $container
    ) {
        parent::__construct($container);
    }

    /**
     * Specify Model class name.
     */
    public function model(): string
    {
        return 'Webkul\SocialLogin\Contracts\CustomerSocialAccount';
    }

    /**
     * @param  array  $providerUser
     * @param  string  $provider
     * @return void
     */
    public function findOrCreateCustomer($providerUser, $provider)
    {
        $account = $this->findOneWhere([
            'provider_name' => $provider,
            'provider_id' => $providerUser->getId(),
        ]);

        if ($account) {
            return $account->customer;
        }

        $email = $providerUser->getEmail() ?: ($providerUser->getId().'@'.$provider.'.local');

        $customer = $this->customerRepository->findOneByField('email', $email);

        if (! $customer) {
            $names = $this->getFirstLastName($providerUser->getName());

            $customer = $this->customerRepository->create([
                'email' => $email,
                'first_name' => $names['first_name'],
                'last_name' => $names['last_name'],
                'status' => 1,
                'is_verified' => ! core()->getConfigData('customer.settings.email.verification'),
                'customer_group_id' => $this->customerGroupRepository->findOneWhere(['code' => 'general'])->id,
            ]);
        }

        $this->create([
            'customer_id' => $customer->id,
            'provider_id' => $providerUser->getId(),
            'provider_name' => $provider,
        ]);

        return $customer;
    }

    /**
     * Returns first and last name from name
     *
     * @param  string  $name
     * @return string
     */
    public function getFirstLastName($name)
    {
        $name = trim((string) $name);

        if ($name === '') {
            return [
                'first_name' => 'Customer',
                'last_name' => '',
            ];
        }

        $parts = preg_split('/\s+/', $name) ?: [];
        $lastName = count($parts) > 1 ? array_pop($parts) : '';
        $firstName = trim(implode(' ', $parts));

        return [
            'first_name' => $firstName ?: 'Customer',
            'last_name' => $lastName,
        ];
    }
}
