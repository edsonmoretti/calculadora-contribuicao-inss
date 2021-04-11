<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    public $title = 'Calculadora de Contribuição do INSS';

    public static function salaryMinimal()
    {
        return 1100.00;
    }

    public static function teto()
    {
        return 6433.57;
    }

}
