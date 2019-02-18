<?php

namespace App\Http\Controllers;

use App\District;
use Illuminate\Http\Request;

/**
 * Class DistrictController
 * @package App\Http\Controllers
 */
class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $field = $request->get('field') ?? 'name';
        $sort = $request->get('sort') ?? 'asc';

        $districts = new District();
        $districts = $districts->where(function ($query) use ($search) {
            $query->where('districts.name', 'like', '%' . $search . '%')
                ->orWhere('districts.area', 'like', '%' . $search . '%')
                ->orWhere('districts.city', 'like', '%' . $search . '%')
                ->orWhere('districts.population', 'like', '%' . $search . '%');
            })
            ->orderBy($field, $sort)
            ->paginate(15)
            ->withPath('?search=' . $search . '&field=' . $field . '&sort=' . $sort);

        return view('districts.index', compact('districts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('districts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validateDistrict();
        District::create($attributes);

        return redirect('/districts');
    }

    /**
     * Display the specified resource.
     *
     * @param District $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        return view('districts.show', compact('district'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param District $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        return view('districts.edit', compact('district'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param District $district
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, District $district)
    {
        $district->update($this->validateDistrict());


        return redirect('/districts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param District $district
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(District $district)
    {
        $district->delete();

        return redirect('/districts');
    }

    private function validateDistrict()
    {
        return request()->validate([
            'name' => 'required|max:255',
            'population' => 'required|integer',
            'city' => 'required|max:255',
            'area' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ]);
    }
}
