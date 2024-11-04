<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

final readonly class DivisionCreator
{
    public function __invoke(array $data): Division
    {
        return Division::create([
            'name' => $data['asciiname'] ?: $data['name'],
            'country_id' => Country::where('code', $data['country code'])->firstOrFail()->id,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'timezone_id' => $data['timezone'],
            'population' => $data['population'],
            'elevation' => $data['elevation'],
            'dem' => $data['dem'],
            'code' => $data['admin1 code'],
            'feature_code' => $data['feature code'],
            'geoname_id' => $data['geonameid'],
        ]);
    }
}
