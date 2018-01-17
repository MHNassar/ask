<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTwitteRequest;
use App\Http\Requests\UpdateTwitteRequest;
use App\Repositories\TwitteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TwitteController extends AppBaseController
{
    /** @var  TwitteRepository */
    private $twitteRepository;

    public function __construct(TwitteRepository $twitteRepo)
    {
        $this->twitteRepository = $twitteRepo;
    }

    /**
     * Display a listing of the Twitte.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->twitteRepository->pushCriteria(new RequestCriteria($request));
        $twittes = $this->twitteRepository->all();

        return view('twittes.index')
            ->with('twittes', $twittes);
    }

    public function geTwittes()
    {
        $twittes = $this->twitteRepository->all();
        return $twittes;
    }

    /**
     * Show the form for creating a new Twitte.
     *
     * @return Response
     */
    public function create()
    {
        return view('twittes.create');
    }

    /**
     * Store a newly created Twitte in storage.
     *
     * @param CreateTwitteRequest $request
     *
     * @return Response
     */
    public function store(CreateTwitteRequest $request)
    {
        $input = $request->all();

        $twitte = $this->twitteRepository->create($input);

        Flash::success('Twitte saved successfully.');

        return redirect(route('twittes.index'));
    }

    /**
     * Display the specified Twitte.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $twitte = $this->twitteRepository->findWithoutFail($id);

        if (empty($twitte)) {
            Flash::error('Twitte not found');

            return redirect(route('twittes.index'));
        }

        return view('twittes.show')->with('twitte', $twitte);
    }

    /**
     * Show the form for editing the specified Twitte.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $twitte = $this->twitteRepository->findWithoutFail($id);

        if (empty($twitte)) {
            Flash::error('Twitte not found');

            return redirect(route('twittes.index'));
        }

        return view('twittes.edit')->with('twitte', $twitte);
    }

    /**
     * Update the specified Twitte in storage.
     *
     * @param  int $id
     * @param UpdateTwitteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTwitteRequest $request)
    {
        $twitte = $this->twitteRepository->findWithoutFail($id);

        if (empty($twitte)) {
            Flash::error('Twitte not found');

            return redirect(route('twittes.index'));
        }

        $twitte = $this->twitteRepository->update($request->all(), $id);

        Flash::success('Twitte updated successfully.');

        return redirect(route('twittes.index'));
    }

    /**
     * Remove the specified Twitte from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $twitte = $this->twitteRepository->findWithoutFail($id);

        if (empty($twitte)) {
            Flash::error('Twitte not found');

            return redirect(route('twittes.index'));
        }

        $this->twitteRepository->delete($id);

        Flash::success('Twitte deleted successfully.');

        return redirect(route('twittes.index'));
    }
}
