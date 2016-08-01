<?php

namespace App\Http\Controllers\SBAuth;

use App\SBModel\ISBAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PDOException;
use Validator;
use App\SBModel\SBEntry;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\User;

class SBAuthController extends Controller implements ISBAuth
{
    //Constructeur
    public function __construct(){

    }


    /**
     * Fonction utiliser pour faire la validation des données du formulaire.
     *
     * @param array $data : Tableau associatif contenant les informations du formulaire
     * @return mixed : Validator
     */
    public function validateData(array $data){

        $datas = array();
        $entry = (new SBEntry())->getEntry();

        //dd(count($entry));

        foreach ($data as $key => $value){

            foreach ($entry as $k => $v){
                if(str_contains($key, $k)){
                    $datas[$key] = $entry[$k];
                    break;
                }
            }
        }

        //dd($datas);

        return Validator::make($data, $datas);
    }

    /**
     * Action à executer à la reception de la
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request, $path, $dbExceptionPath){

        //On recupère les information du formulaire dans un tableau associatif (Clé valeur).
        $data = $request->all();

        //On valide les données
        $validator = $this->validateData($data);

        //On teste si la requête a échoué ou pas
        if($validator->fails()){
            return $this->onErrorInValidation($request, $validator);
        }


        //Creation ou encore Enregistrement de l'utilisateur.
        try{
            $this->createUser($data);
        }catch(PDOException $e){
            return redirect($dbExceptionPath)->withErrors(["email" => "L'adresse email existe déjà !"]);
        }

        return redirect($path);
    }


    public function onErrorInValidation(Request $request, $validator)
    {
        // TODO: Implement onErrorInValidation() method.

        $customErrors = array();
        $errors = $validator->messages();


        //Construction du message d'erreur
        $requestData = $request->all();
        foreach ($requestData as $key => $value){
            if(count($errors->get($key))){
                $customErrors[$key] = "Le champs ($key) ne respecte pas le format requis !";
            }
        }

        //On conserve les données dans la session pour la requête suivante.
        Input::flash();
        return Redirect::back()
            ->withErrors($customErrors)
            ->withInput(Input::except('password'));
    }


    public function createUser(array $array)
    {
        // TODO: Implement createUser() method.

        //On cree un tableau qui va contenir le mot de passe formatter
        $arrayToInsert = array();
        foreach ($array as $key => $value){
            $arrayToInsert[$key] = $value;
            if(str_contains($key, "password")){
                $arrayToInsert[$key] = Hash::make($value);
            }
        }

        User::create($arrayToInsert);
    }


}
