<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
  //Show all listings
  public function index()
  {
    return view('listings.index', [
      'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
    ]);
  }
  //Show single listing by ID
  public function show(Listing $listing)
  {
    return view('listings.show', [
      'listing' => $listing,
      'tags' => explode(', ', $listing->tags)
    ]);
  }
  //Show create listing page
  public function create()
  {
    return view('listings.create');
  }

  // Validate
  public function validation(bool $store, Request $request)
  {
    return $request->validate([
      'title' => 'required',
      'company' => ($store) ? ['required', Rule::unique('listings', 'company')] : ['required'],
      'location' => 'required',
      'website' => 'required',
      'email' => ['required', 'email'],
      'tags' => 'required',
      'description' => 'required'
    ]);
  }

  //Store listing data
  public function store(Request $request)
  {
    $formFields = $this->validation(true, $request);
    if ($request->hasFile('logo')) {
      $formFields['logo'] = 'storage/' . $request->file('logo')->store('logos', 'public');
    }

    $formFields['user_id'] = auth()->id();

    Listing::create($formFields);
    return redirect('/')->with('message', 'Listing created successfully');
  }
  //Edit listing page
  public function edit(Listing $listing)
  {
    if ($listing->user_id !== auth()->id()) {
      abort(403, 'Unauthorized Action');
    }
    return view('listings.edit', ['listing' => $listing]);
  }
  //Update listing
  public function update(Listing $listing, Request $request)
  {
    if ($listing->user_id !== auth()->id()) {
      abort(403, 'Unauthorized Action');
    }

    $formFields = $this->validation(false, $request);
    if ($request->hasFile('logo')) {
      $formFields['logo'] = 'storage/' . $request->file('logo')->store('logos', 'public');
      if ($listing->logo && file_exists($listing->logo)) unlink($listing->logo);
    }
    $listing->update($formFields);
    return redirect("listings/$listing->id")->with('message', 'Updated listing successfully');
  }
  //Delete listing
  public function destroy(Listing $listing)
  {
    if ($listing->user_id !== auth()->id()) {
      abort(403, 'Unauthorized Action');
    }
    if ($listing->logo && file_exists($listing->logo)) unlink($listing->logo);
    $listing->delete();
    return redirect('/')->with('message', 'Listing destroyed');
  }

  //Manage listing
  public function manage()
  {
    return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
  }
}
