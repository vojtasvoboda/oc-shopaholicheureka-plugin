<?php namespace VojtaSvoboda\ShopaholicHeureka\Models;

use Model;
use October\Rain\Database\Traits\Validation as ValidationTrait;

class Settings extends Model
{
    use ValidationTrait;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'vojtasvoboda_shopaholicheureka_settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'secret_key_cz' => 'required_without:secret_key_sk|size:32',
        'secret_key_sk' => 'required_without:secret_key_cz|size:32',
    ];
}
