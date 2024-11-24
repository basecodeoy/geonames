<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames\Database\Factories;

use BaseCodeOy\GeoNames\PostalCode;
use Illuminate\Database\Eloquent\Factories\Factory;

final class PostalCodeFactory extends Factory
{
    protected $model = PostalCode::class;

    public function definition()
    {
        return [
            'country_code' => $this->faker->countryCode,
            'postal_code' => $this->faker->postcode,
            'place_name' => $this->faker->city,
            'admin_name1' => $this->faker->state,
            'admin_code1' => $this->faker->stateAbbr,
            'admin_name2' => $this->faker->city,
            'admin_code2' => $this->faker->stateAbbr,
            'admin_name3' => $this->faker->city,
            'admin_code3' => $this->faker->stateAbbr,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'accuracy' => $this->faker->numberBetween(1, 6),
        ];
    }
}
