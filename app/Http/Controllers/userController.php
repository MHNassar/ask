<?php

namespace App\Http\Controllers;

use App\DataTables\userDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateuserRequest;
use App\Http\Requests\UpdateuserRequest;
use App\Repositories\userRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class userController extends AppBaseController
{
    /** @var  userRepository */
    private $userRepository;

    public function __construct(userRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the user.
     *
     * @param userDataTable $userDataTable
     * @return Response
     */
    public function index(userDataTable $userDataTable)
    {
        $users = $this->userRepository->all()->where('type', 1);
        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param CreateuserRequest $request
     *
     * @return Response
     */
    public function store(CreateuserRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path();
            $image->move($destinationPath, $imageName);
            $photo = $imageName;
            $input['photo'] = $photo;
        }
        $input['type'] = 1;

        $user = $this->userRepository->create($input);

        Flash::success('تم الاضافه بنجاح ');

        return redirect(route('users.index'));
    }

    /**
     * Display the specified user.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  int $id
     * @param UpdateuserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateuserRequest $request)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $input = $request->all();
        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path();
            $image->move($destinationPath, $imageName);
            $photo = $imageName;
            $input['photo'] = $photo;
        }

        $user = $this->userRepository->update($input, $id);

        Flash::success('تم التعديل بنجاح');

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('تم الحزف بنجاح');

        return redirect(route('users.index'));
    }
}
