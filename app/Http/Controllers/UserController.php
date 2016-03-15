<?php

namespace ApiTripCuba\Http\Controllers;

use Illuminate\Http\Request;
use ApiTripCuba\Entities\User;
use ApiTripCuba\Http\Requests;
use ApiTripCuba\Transformers\UserTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;


class UserController extends Controller
{
    public function __construct()
	{
		//$this->middleware('oauth', ['only' => ['store', 'update', 'destroy']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Solo los administradores pueden tener acceso a la lista de usuario
		/*$fractal = new Manager();
        $paginator = userr::name($request->name)
                        ->last_name($request->last_name)
                        ->email($request->email)
                        ->paginate(20);
        $user = $paginator->getCollection();

        $resource = new Collection($user, new UserTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        return response($fractal->createData($resource)->toArray());*/
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{//usar el grant_type client_credentials para poder crear el usuario

		if(!$request->input('first_name') || ! $request->input('last_name') || ! $request->input('email') || ! $request->input('password') || ! $request->input('last_name'))
		{
			return response()->json(['mensaje' => 'No se pudieron procesar los valores, faltan valores, o valores incorrectos', 'codigo' => 422],422);
		}
		$user = new User($request->all());
		$user -> password = bcrypt($user->password);
		$user->save();

		return response()->json(['mensaje' => 'Se ha registrado correctamente'],201);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		$fractal = new Manager();
        $user = User::find($id);
        if(!$user)
		{
			return response()->json(['mensaje' => 'No se encuentra este usuario', 'codigo' => 404],404);
		}
        $resource = new Item($user, new UserTransformer);
        return response($fractal->createData($resource)->toArray());

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$metodo = $request->method();
		$user = User::find($id);

		if(!$user)
		{
			return response()->json(['mensaje' => 'No se encuentra este usuario', 'codigo' => 404],404);
		}

		if($metodo === 'PATCH')
		{
			$bandera = false;
			$first_name = $request->input('first_name');
			
			if($first_name != null && $first_name != '')
			{
				$user->first_name = $first_name;
				$bandera = true;
			}

			$last_name = $request->input('last_name');

			if($last_name != null && $last_name != '')
			{
				$user->last_name = $last_name;
				$bandera = true;
			}

			$email = $request->input('email');

			if($email != null && $email != '')
			{
				$user->email = $email;
				$bandera = true;
			}

			$birthdate = $request->input('birthdate');

			if($birthdate != null && $birthdate != '')
			{
				$user->birthdate = $birthdate;
				$bandera = true;
			}

			$notification = $request->input('notification');

			if($notification != null && $notification != '')
			{
				$user->notification = $notification;
				$bandera = true;
			}

			$password =$request->input('password');

			if($password != null && $password != '')
			{

				$user->password =  bcrypt($password);
				$bandera = true;
			}

			if($bandera)
			{
				$user->save();
				return response()->json(['mensaje' => 'Sus datos han sido actualizados exitosamente'],200);
			}

			return response()->json(['mensaje' => 'No se modificó ningun usuario'],200);
		}

		$first_name = $request->input('first_name');
		$last_name = $request->input('last_name');
		$email = $request->input('email');
		$password = $request->input('password');
		$notification = $request->input('notification');
		$birthdate = $request->input('birthdate');
		if(!$first_name || !$last_name || !$email || !$password || !$notification || !$birthdate)
		{
			return response()->json(['mensaje' => 'No se pudieron procesar los valores', 'codigo' => 422],422);
		}
		$user->first_name = $first_name;
		$user->last_name = $last_name;
		$user->email = $email;
		$user->password = $password;
		$user->notification = $notification;
		$user->birthdate = $birthdate;

		$user->save();


		return response()->json(['mensaje' => 'Usuario editado'],200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = User::find($id);

		if(!$user)
		{
			return response()->json(['mensaje' => 'No se encuentra este usuario', 'codigo' => 404],404);
		}

	/*	$vehiculos = $fabricante->vehiculos;

		if(sizeof($vehiculos) > 0)
		{
			return response()->json(['mensaje' => 'Este fabricante posee vehiculos asociados y no puede ser eliminado. Eliminar primero sus vehiculos.', 'codigo' => 409],409);
		}*/

		$user->delete();

		return response()->json(['mensaje' => 'Usuario eliminado'],200);
	}
}

