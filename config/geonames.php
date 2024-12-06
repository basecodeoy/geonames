<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\GeoNames\AdministrativeCode;
use BaseCodeOy\GeoNames\AdministrativeCodeSeeder;
use BaseCodeOy\GeoNames\AlternateName;
use BaseCodeOy\GeoNames\AlternateNameSeeder;
use BaseCodeOy\GeoNames\City;
use BaseCodeOy\GeoNames\CitySeeder;
use BaseCodeOy\GeoNames\Continent;
use BaseCodeOy\GeoNames\ContinentSeeder;
use BaseCodeOy\GeoNames\Country;
use BaseCodeOy\GeoNames\CountrySeeder;
use BaseCodeOy\GeoNames\Division;
use BaseCodeOy\GeoNames\DivisionSeeder;
use BaseCodeOy\GeoNames\FeatureCode;
use BaseCodeOy\GeoNames\FeatureCodeSeeder;
use BaseCodeOy\GeoNames\Language;
use BaseCodeOy\GeoNames\LanguageSeeder;
use BaseCodeOy\GeoNames\PostalCode;
use BaseCodeOy\GeoNames\PostalCodeSeeder;
use BaseCodeOy\GeoNames\TimeZone;
use BaseCodeOy\GeoNames\TimeZoneSeeder;

return [
    /*
    |--------------------------------------------------------------------------
    | Directory Configuration
    |--------------------------------------------------------------------------
    |
    | Define the path where Geonames data will be stored temporarily. It uses
    | Laravel's `storage_path` helper function, which generates a fully qualified
    | path to a given file relative to the storage directory.
    |
    */
    'directory' => storage_path('tmp/geonames'),

    /*
    |--------------------------------------------------------------------------
    | Models Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define the class names for the models used by your
    | application. This allows for easy reference to model classes
    | throughout your code.
    |
    */
    'models' => [
        /*
        |--------------------------------------------------------------------------
        | Administrative Code Model
        |--------------------------------------------------------------------------
        |
        | Define the class used for the administrative code model. This class
        | handles data and operations related to administrative codes.
        |
        */
        'administrative_code' => AdministrativeCode::class,

        /*
        |--------------------------------------------------------------------------
        | Alternate Name Model
        |--------------------------------------------------------------------------
        |
        | Define the class used for the alternate name model. This class handles
        | data and operations related to alternate names.
        |
        */
        'alternate_name' => AlternateName::class,

        /*
        |--------------------------------------------------------------------------
        | City Model
        |--------------------------------------------------------------------------
        |
        | Define the class used for the city model. This class handles data
        | and operations related to cities.
        |
        */
        'city' => City::class,

        /*
        |--------------------------------------------------------------------------
        | Continent Model
        |--------------------------------------------------------------------------
        |
        | Define the class used for the continent model. This class handles
        | data and operations related to continents.
        |
        */
        'continent' => Continent::class,

        /*
        |--------------------------------------------------------------------------
        | Country Model
        |--------------------------------------------------------------------------
        |
        | Define the class used for the country model. This class handles
        | data and operations related to countries.
        |
        */
        'country' => Country::class,

        /*
        |--------------------------------------------------------------------------
        | Division Model
        |--------------------------------------------------------------------------
        |
        | Define the class used for the division model. This class handles
        | data and operations related to divisions.
        |
        */
        'division' => Division::class,

        /*
        |--------------------------------------------------------------------------
        | Feature Code Model
        |--------------------------------------------------------------------------
        |
        | Define the class used for the feature code model. This class handles
        | data and operations related to feature codes.
        |
        */
        'feature_code' => FeatureCode::class,

        /*
        |--------------------------------------------------------------------------
        | Language Model
        |--------------------------------------------------------------------------
        |
        | Define the class used for the language model. This class handles
        | data and operations related to languages.
        |
        */
        'language' => Language::class,

        /*
        |--------------------------------------------------------------------------
        | Postal Code Model
        |--------------------------------------------------------------------------
        |
        | Define the class used for the postal code model. This class handles
        | data and operations related to postal codes.
        |
        */
        'postal_code' => PostalCode::class,

        /*
        |--------------------------------------------------------------------------
        | Time Zone Model
        |--------------------------------------------------------------------------
        |
        | Define the class used for the time zone model. This class handles
        | data and operations related to time zones.
        |
        */
        'time_zone' => TimeZone::class,
    ],
    /*
    |--------------------------------------------------------------------------
    | Seeders Configuration
    |--------------------------------------------------------------------------
    |
    | Define the list of seeder classes that will be used to populate your
    | database. Uncomment the seeders that you wish to use. This list will be
    | processed during the seeding process.
    |
    */
    'seeders' => [
        // These seeders, being free of dependencies, must run first.
        AdministrativeCodeSeeder::class,
        FeatureCodeSeeder::class,
        LanguageSeeder::class,
        // These seeders have dependencies and should be run last, in this order.
        ContinentSeeder::class,
        CountrySeeder::class,
        DivisionSeeder::class,
        CitySeeder::class,
        TimeZoneSeeder::class,
        PostalCodeSeeder::class,
        // This seeder has dependencies and due to the volume of data, it should be run last.
        AlternateNameSeeder::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Tables Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define the configuration for the database tables used by
    | your application. This allows for easy reference to table names
    | throughout your code. Each key is the name used in the code and each
    | value is the actual name of the table in the database.
    |
    */
    'tables' => [
        /*
        |--------------------------------------------------------------------------
        | Administrative Codes Table
        |--------------------------------------------------------------------------
        |
        | Define the name for the administrative codes table used to store
        | administrative code related information.
        |
        */
        'administrative_code' => 'geonames_administrative_codes',

        /*
        |--------------------------------------------------------------------------
        | Alternate Names Table
        |--------------------------------------------------------------------------
        |
        | Define the name for the alternate names table used to store alternate
        | name related information.
        |
        */
        'alternate_name' => 'geonames_alternate_names',

        /*
        |--------------------------------------------------------------------------
        | Cities Table
        |--------------------------------------------------------------------------
        |
        | Define the name for the cities table used to store city related information.
        |
        */
        'city' => 'geonames_cities',

        /*
        |--------------------------------------------------------------------------
        | Continents Table
        |--------------------------------------------------------------------------
        |
        | Define the name for the continents table used to store continent related
        | information.
        |
        */
        'continent' => 'geonames_continents',

        /*
        |--------------------------------------------------------------------------
        | Countries Table
        |--------------------------------------------------------------------------
        |
        | Define the name for the countries table used to store country related
        | information.
        |
        */
        'country' => 'geonames_countries',

        /*
        |--------------------------------------------------------------------------
        | Divisions Table
        |--------------------------------------------------------------------------
        |
        | Define the name for the divisions table used to store division related
        | information.
        |
        */
        'division' => 'geonames_divisions',

        /*
        |--------------------------------------------------------------------------
        | Feature Codes Table
        |--------------------------------------------------------------------------
        |
        | Define the name for the feature codes table used to store feature code
        | related information.
        |
        */
        'feature_code' => 'geonames_feature_codes',

        /*
        |--------------------------------------------------------------------------
        | Languages Table
        |--------------------------------------------------------------------------
        |
        | Define the name for the languages table used to store language related
        | information.
        |
        */
        'language' => 'geonames_languages',

        /*
        |--------------------------------------------------------------------------
        | Postal Codes Table
        |--------------------------------------------------------------------------
        |
        | Define the name for the postal codes table used to store postal code
        | related information.
        |
        */
        'postal_code' => 'geonames_postal_codes',

        /*
        |--------------------------------------------------------------------------
        | Time Zones Table
        |--------------------------------------------------------------------------
        |
        | Define the name for the time zones table used to store time zone related
        | information.
        |
        */
        'time_zone' => 'geonames_time_zones',
    ],

    /*
    |--------------------------------------------------------------------------
    | Data Sources Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can specify the configuration for the data sources used by
    | your application. These sources are utilized to populate the geonames
    | related data for the application.
    |
    */
    'sources' => [
        /*
        |--------------------------------------------------------------------------
        | Cities Data Source
        |--------------------------------------------------------------------------
        |
        | Define the data source for the cities. The numeric values represent the
        | population threshold for the cities. Only cities with a population above
        | these thresholds are included in the data.
        |
        */
        'cities' => [
            500,
            1_000,
            5_000,
            15_000,
        ],

        /*
        |--------------------------------------------------------------------------
        | Postal Codes Data Source
        |--------------------------------------------------------------------------
        |
        | Define the data source for the postal codes. The details of the data source
        | would be provided here.
        |
        */
        'postal_codes' => [
            'AD',
            'AR',
            'AS',
            'AT',
            'AU',
            'AX',
            'AZ',
            'BD',
            'BE',
            'BG',
            'BM',
            'BR',
            'BY',
            'CA',
            'CA_full.csv',
            'CH',
            'CL',
            'CO',
            'CR',
            'CY',
            'CZ',
            'DE',
            'DK',
            'DO',
            'DZ',
            'EE',
            'ES',
            'FI',
            'FM',
            'FO',
            'FR',
            'GB',
            'GB_full.csv',
            'GF',
            'GG',
            'GL',
            'GP',
            'GT',
            'GU',
            'HR',
            'HT',
            'HU',
            'IE',
            'IM',
            'IN',
            'IS',
            'IT',
            'JE',
            'JP',
            'KR',
            'LI',
            'LK',
            'LT',
            'LU',
            'LV',
            'MA',
            'MC',
            'MD',
            'MH',
            'MK',
            'MP',
            'MQ',
            'MT',
            'MW',
            'MX',
            'MY',
            'NC',
            'NL',
            'NL_full.csv',
            'NO',
            'NZ',
            'PE',
            'PH',
            'PK',
            'PL',
            'PM',
            'PR',
            'PT',
            'PW',
            'RE',
            'RO',
            'RS',
            'RU',
            'SE',
            'SG',
            'SI',
            'SJ',
            'SK',
            'SM',
            'TH',
            'TR',
            'UA',
            'US',
            'UY',
            'VA',
            'VI',
            'WF',
            'YT',
            'ZA',
            'allCountries',
        ],
    ],
];
