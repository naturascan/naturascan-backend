<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\WelcomeEmail;
use App\Mail\ForgotPasswordEmail;
use Illuminate\Support\Carbon;
use App\Mail\UpdatePasswordEmail;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * @OA\Info(
 *     title="Naturascan API",
 *     version="1.0.0",
 *     description="Naturascan API",
 *     @OA\Contact(
 *         name="Gilles",
 *         email="gillesakakpo01@gmail.com"
 *     ),
 *      
 * )
 * 
 * @OA\Components()
 */

class AuthController extends Controller
{
    public $customMessages = [
        'required' => 'Le champ :attribute est requis.',
        'string' => 'Le champ :attribute doit être une chaîne de caractères.',
        'max' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
        'email' => 'Le champ :attribute doit être une adresse email valide.',
        'unique' => ':attribute déjà utilisé.',
        'date' => 'Le champ :attribute doit être une date valide.',
        'min' => ':attribute doit contenir au moins :min caractères.',
        'in' => ':attribute doit être dans l\'une des valeurs suivantes : :values.',
        'dimensions' => 'Les dimensions de l\'image :attribute ne sont pas correctes. Les dimensions attendues sont : :width pixels de largeur et :height pixels de hauteur.',
    ];

    /**
     * @OA\Post(
     *     path="/api/login",
     *     operationId="authLogin",
     *     tags={"Authentication"},
     *     summary="Se connecter",
     *     @OA\RequestBody(
     *         description="Champs d'authentification",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="utilisateur@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="motdepasse"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Connexion réussie",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=202,
     *         description="Compte bloqué",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreurs de validation",
     *     ),
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'string',
            // 'pseudo'=>'string',
            'password' => 'required',
        ], $this->customMessages);
        
        $errors = $validator->errors();

        if ($errors->count()) {
            return response()->json(array('message' => $errors->first(), 'data' => $errors), 422);
        }
 
        $user = User::where('pseudo', $request->email)->first();
       
        if(!$user){
            $user = User::where('email', $request->email)->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Les informations d\'identification sont incorrectes.'],
            ]);
        }

        if(!$user->enabled){
            return response()->json(array('message' => __("Compte bloqué!")), 202);
            
        }

        // create token with no expiration date
        
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     operationId="authLogout",
     *     tags={"Authentication"},
     *     summary="Se déconnecter",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Déconnexion réussie",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non autorisé",
     *     ),
     * security={{"sanctum": {}}}
     * 
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Vous avez été déconnecté.']);
    }

    /**
     * @OA\Get(
     *     path="/api/me",
     *     operationId="authMe",
     *     tags={"Authentication"},
     *     summary="Obtenir les informations de l'utilisateur authentifié",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Récupération réussie des informations de l'utilisateur authentifié",
     *          @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string"),
     *          ),
     *         
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non autorisé",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Token invalide",
     *             ),
     *         ),
     *     ),
     * security={{"sanctum": {}}}
     * 
     * )
     */
    public function me()
    {
        try {
            $user = Auth::user();
            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token invalide'], 401);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     operationId="authRegister",
     *     tags={"Authentication"},
     *     summary="Inscription d'un nouvel utilisateur",
     *     @OA\RequestBody(
     *         description="Champs d'inscription d'un nouvel utilisateur",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="firstname", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@yopmail.com", description="Adresse email unique de l'utilisateur"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678", description="Mot de passe de l'utilisateur (min. 8 caractères)"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="12345678", description="Mot de passe de l'utilisateur (min. 8 caractères)"),
     *             @OA\Property(property="mobile_number", type="string", example="02056852", description="Téléphone"),
     *             @OA\Property(property="adress", type="string", example="johndoe", description="Adresse"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inscription réussie",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(
     *                     property="access_token",
     *                     type="string",
     *                     example="votre_access_token",
     *                 ),
     *                 @OA\Property(
     *                     property="token_type",
     *                     type="string",
     *                     example="Bearer",
     *                 ),
     *             },
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreurs de validation",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Erreur de validations",
     *                 ),
     *             },
     *         ),
     *     ),
     * )
    */
    public function register(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'pseudo' => 'required|string|unique:users',
            'firstname' => 'required|string',
            'mobile_number' => 'string',
            'access' => 'string',
            'adress' => 'string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ], $this->customMessages);

        $errors = $validator->errors();

        if ($errors->count()) {
            return response()->json(array('message' => $errors->first(), 'data' => $errors), 422);
        }
         
        $user = new User;
        $user->name = $request->name;
        $user->firstname = $request->firstname;
        $user->pseudo = $request->pseudo;
        $user->email = $request->email;
        $user->mobile_number = $request->mobile_number;
        $user->adress = $request->adress;
        $user->access = $request->access;
        $user->enabled=true;
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        Mail::to($user->email)->bcc('gillesakakpo01@gmail.com')->bcc('sogbossimichee4@gmail.com')->send(new WelcomeEmail($user));

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
 

 
    /**
     * @OA\Post(
     *     path="/api/refreshToken",
     *     operationId="authRefreshToken",
     *     tags={"Authentication"},
     *     summary="Actualiser le jeton d'authentification de l'utilisateur",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Jeton d'authentification actualisé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(
     *                     property="access_token",
     *                     type="string",
     *                     description="Le nouveau jeton d'authentification actualisé",
     *                 ),
     *                 @OA\Property(
     *                     property="token_type",
     *                     type="string",
     *                     description="Type de jeton (Bearer)",
     *                 ),
     *             },
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Accès non autorisé (token d'authentification manquant ou invalide)",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Token invalide",
     *                 ),
     *             },
     *         ),
     *     ),
     * security={{"sanctum": {}}}
     * 
     * )
     */
    public function refreshToken(Request $request)
    {
        
        try {
            $user = $request->user();
            $user->tokens()->delete();

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token invalide'], 401);
            // return error message
            // $message = $e->getMessage();
            // return response()->json(['message' => $message], 401);
            
        }
    }


    /**
     * @OA\Post(
     *     path="/api/forgotPassword",
     *     operationId="authForgotPassword",
     *     tags={"Authentication"},
     *     summary="Demander un code de reinitialisation de mot de passe",
     *     @OA\Response(
     *         response=200,
     *         description="Code de reinitialisation envoyé",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Nous vous avons envoyé un code de réinitialisation!",
     *                 ), 
     *             },
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreurs de validations",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                 ),
     *             },
     *         ),
     *     ),
     * )
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ], $this->customMessages);

        $errors = $validator->errors();

        if ($errors->count()) {
            return response()->json(array('message' => $errors->first(), "data" => $errors), 422);
        }

        $email = $request->email;

        $existingRecord = DB::table('password_reset_tokens')->where('email', $email)->first();

        if ($existingRecord) {
            $code = $existingRecord->token;
        } else {
            $code = mt_rand(100000, 999999);

            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $code,
                'created_at' => Carbon::now()
            ]);
        }

        $user = User::where('email', $request->email)->first();
        
        Mail::to($user->email)->send(new ForgotPasswordEmail($code));

        return response()->json([
            'code' => 200,
            'message' => 'Code de réinitialisation envoyé!'
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/updatePassword",
     *     operationId="authUpdatePassword",
     *     tags={"Authentication"},
     *     summary="Reinitialisation de mot de passe",
     *     @OA\RequestBody(
     *         description="Champs pour reinitialiser le mot de passe",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="string", example="4568"),
     *             @OA\Property(property="password", type="string", format="password", example="motdepasse"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mot de passe reinitialisé!",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Mot de passe reinitialisé!",
     *                 ), 
     *             },
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreurs de validations",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Erreurs de validations!",
     *                 ),
     *             },
     *         ),
     *     ),
     * @OA\Response(
     *         response=401,
     *         description="Code invalide",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Code invalide!",
     *                 ),
     *             },
     *         ),
     *     ),
     * )
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6',
            'code' => 'required|integer',
        ], $this->customMessages);

        $errors = $validator->errors();

        if ($errors->count()) {
            $response = array('code' => 422, 'message' => $errors->first(), "data" => $errors);
            return response()->json($response, 422);
        }

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->code
            ])
            ->first();

        if (!$updatePassword) {
            $response = array('code' => 401, 'message' => __("Code invalide!"));
            return response()->json($response, 401);
        }

        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();
        Mail::to($user->email)->send(new UpdatePasswordEmail($user));

        return response()->json([
            'code' => 200,
            'message' => 'Mot de passe reinitialisé!'
        ]);
    }

 
    /**
 * @OA\Post(
 *     path="/api/changePassword",
 *     operationId="authChangePassword",
 *     tags={"Authentication"},
 *     summary="Changer le mot de passe",
 *     @OA\RequestBody(
 *         description="Champs pour changer le mot de passe",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="old_password", type="string", format="password", example="ancienmotdepasse"),
 *             @OA\Property(property="new_password", type="string", format="password", example="nouveaumotdepasse"),
 *             @OA\Property(property="new_password_confirmation", type="string", format="password", example="nouveaumotdepasse"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Mot de passe changé avec succès!",
 *         @OA\JsonContent(
 *             type="object",
 *             properties={
 *                 @OA\Property(
 *                     property="message",
 *                     type="string",
 *                     description="Mot de passe changé avec succès!",
 *                 ),
 *             },
 *         ),
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Mot de passe actuel incorrect",
 *         @OA\JsonContent(
 *             type="object",
 *             properties={
 *                 @OA\Property(
 *                     property="message",
 *                     type="string",
 *                     description="Mot de passe actuel incorrect!",
 *                 ),
 *             },
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erreurs de validations",
 *         @OA\JsonContent(
 *             type="object",
 *             properties={
 *                 @OA\Property(
 *                     property="message",
 *                     type="string",
 *                     description="Erreurs de validations!",
 *                 ),
 *             },
 *         ),
 *     ),
 * security={{"sanctum": {}}}
 * 
 * )
 */
public function changePassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'old_password' => 'required|string|min:6',
        'new_password' => 'required|string|min:6|confirmed',
        'new_password_confirmation' => 'required|string|min:6', 
    ], $this->customMessages);

    $errors = $validator->errors();

    if ($errors->count()) {
        $response = array('code' => 422, 'message' => $errors->first(), "data" => $errors);
        return response()->json($response, 422);
    }

    $user = Auth::user();

    // Vérifier si l'ancien mot de passe est correct
    if (!Hash::check($request->old_password, $user->password)) {
        return response()->json([
            'code' => 401,
            'message' => 'Mot de passe actuel incorrect!'
        ]);
    }

    // Mettre à jour le mot de passe
    $user->update(['password' => Hash::make($request->new_password)]);

    return response()->json([
        'code' => 200,
        'message' => 'Mot de passe changé avec succès!'
    ]);
}

    /**
     * @OA\Get(
     *     path="/api/observers",
     *     operationId="getObservers",
     *     tags={"Authentication"},
     *     summary="Obtenir la liste des observateurs",
     * security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des observateurs",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User"),
     *         ),
     *     ),
     * security={{"sanctum": {}}}
     * )
     */
    public function observers(){
        $users = User::where('access', 'observer')->get();
        return response()->json($users);
    }

    /**
     * @OA\Post(
     *     path="/api/deleteAccount",
     *     operationId="deleteAccount",
     *     tags={"Authentication"},
     *     summary="Supprimer le compte de l'utilisateur authentifié",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Compte supprimé avec succès!",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Compte supprimé avec succès!",
     *                 ),
     *             },
     *         ),
     *     ),
     * security={{"sanctum": {}}}
     * 
     * )
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        $user->delete();
        return response()->json(['message' => 'Compte supprimé avec succès!']);
    }

     

}