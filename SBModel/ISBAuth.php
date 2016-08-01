<?php
namespace App\SBModel;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: SEYDOU BERTHE
 * Date: 01/08/2016
 * Time: 11:50
 */

interface ISBAuth {

    /**
     * Fonction utiliser pour l'enregistrement
     * C'est l'action associer au controlleur
     *
     * @param Requestuest $request
     * @param $nextPath path where redirect when everything is alright
     * @return mixed
     */
    public function register(Request $request, $nextPath, $dbExeptionPath);


    /**
     * Fonction utiliser pour valider les paramêtres du formulaire
     *
     * @param $data
     * @return mixed
     */
    public function validateData(array $data);

    /**
     *  Fonction utiliser pour faire la redirection en cas d'erreur de validation
     *
     * @param Request $request
     * @param Validator $validator
     * @param $redirectPath
     * @return mixed
     */
    public function onErrorInValidation(Request $request, $validator);


    /**
     *
     * Fonction utiliser pour enregistrer un  utilisateur dans la base de donnée
     *
     * @param array $array
     * @return mixed
     */
    public function createUser(array $array);

}