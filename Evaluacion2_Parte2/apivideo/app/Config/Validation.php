<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    public $peliculas =[
        'titulo' => 'required|min_length[1]|max_length[50]',
        'anyo' => 'required|less_than[2022]|greater_than[1894]',
        'duracion' => 'required|less_than[241]|greater_than[1]',
        'id_director' => 'required|integer'
    ];

    public $actores =[
        'nombre' => 'required|min_length[1]|max_length[50]',
        'anyoNacimiento' => 'required|less_than[2022]|greater_than[1800]',
        'pais' => 'required|min_length[1]|max_length[50]'
    ];

    public $directores =[
        'nombre' => 'required|min_length[1]|max_length[50]',
        'anyoNacimiento' => 'required|less_than[2022]|greater_than[1800]',
        'pais' => 'required|min_length[1]|max_length[50]'
    ];
}
