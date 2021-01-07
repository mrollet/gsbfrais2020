<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\GsbFrais;
use Exception;

class ConnexionController extends Controller
{
    /**
     * Authentifie le visiteur 
     * @param $request : objet request avec login et mdp
     * @return type Vue formLogin ou home
     */
    public function logIn(Request $request) {
        $login = $request->input('login');
        $pwd = $request->input('pwd'); 
        $gsbFrais = new GsbFrais();
        $visiteur = $gsbFrais->getInfosVisiteur($login,$pwd);
        //var_dump(serialize($visiteur));
        if(is_null($visiteur)){
            Session::put('id', '0');
            $erreur = "Login ou mot de passe inconnu !";
            //Session::flash('erreur', $erreur);
            // return back()->withInput($request->except('pwd'));
             return back()->with('erreur', $erreur);
        }
        else{
            $id = $visiteur->id;
            $nom =  $visiteur->nom;
            $prenom = $visiteur->prenom;
            Session::put('id', $id);
            Session::put('nom', $nom);
            Session::put('prenom', $prenom);
//            return view('home');
            return redirect('/');
        }
    }
    
    /**
     * Déconnecte le visiteur authentifié
     * @return type Vue home
     */
    public function logOut(){
        Session::put('id', '0');
//        Session::forget('id');
        return view('home');
    }
}
