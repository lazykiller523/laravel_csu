<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Record::all();

        $records = Record::all();

        $this->authorize('viewAny', Record::class);

        return view('records.index', ['records' => $records]);

        return view('index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Record::class);

        return view('records.create');

        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:records,email',
        ]);
    
        $record = new Record([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
        ]);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:records|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
        ]);

        return redirect('/')->with('success', 'Record saved!');

        $record = Record::create($validatedData);
        activity()
            ->causedBy(Auth::user())
            ->performedOn($record)
            ->withProperties($validatedData)
            ->log('Record created');

        return redirect('/records')->with('success', 'Record created successfully.');

        // Save the record to the database
        $record->save();

         // Validate the input
         $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:records|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
        ]);

        // Create the record
        $record = new Record($validatedData);
        $record->user_id = Auth::user()->id;
        $record->save();

        // Log the activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($record)
            ->withProperties($validatedData)
            ->log('Record created');

        // Redirect to the record list view
        return redirect('/records')->with('success', 'Record created successfully.');
        
        // Validate the file upload
    $request->validate([
        'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        'tags' => 'nullable|string|max:255',
    ]);

    // Get the authenticated user
    $user = Auth::user();

    // Save the file
    $file = new File;
    $file->user_id = $user->id;
    $file->name = $request->file('file')->getClientOriginalName();
    $file->path = $request->file('file')->store('uploads');
    $file->tags = $request->input('tags');
    $file->save();

    // Redirect to the file list view
    return redirect('/files')->with('success', 'File uploaded successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = Record::findOrFail($id);

        return view('show', compact('record'));

        $this->authorize('view', $record);

        return view('records.show', ['record' => $record]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $record = Record::findOrFail($id);

       return view('edit', compact('record'));

       $this->authorize('update', $record);

       return view('records.edit', ['record' => $record]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:records,email,'.$id,
            ]);
        $record = Record::findOrFail($id);
        $record->name = $request->get('name');
        $record->email = $request->get('email');
        $record->phone = $request->get('phone');
        $record->address = $request->get('address');
        $record->save();
            
        return redirect('/')->with('success', 'Record updated!');
        
        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:records,email,' . $record->id . '|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
        ]);

        // Update the record
        $record->update($validatedData);

        // Log the activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($record)
            ->withProperties($validatedData)
            ->log('Record updated');

        // Redirect to the record list view
        return redirect('/records')->with('success', 'Record updated successfully.');

        $this->authorize('update', $record);

        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:records,email,'.$record->id.'|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
        ]);
    
        // Update the record
        $record->fill($validatedData);
        $record->save();
    
        // Log the activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($record)
            ->withProperties($validatedData)
            ->log('Record updated');
    
        // Redirect to the record list view
        return redirect('/records')->with('success', 'Record updated successfully.');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Record::findOrFail($id);
        $record->delete();

        return redirect('/')->with('success', 'Record deleted!');

                // Delete the record
                $record->delete();

                // Log the activity
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($record)
                    ->log('Record deleted');
        
                // Redirect to the record list view
                return redirect('/records')->with('success', 'Record deleted successfully.');
        
        $this->authorize('delete', $record);

                // Log the activity
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($record)
                    ->log('Record deleted');
            
                // Delete the record
                $record->delete();
            
                // Redirect to the record list view
                return redirect('/records')->with('success', 'Record deleted successfully.');
            
    }
}
