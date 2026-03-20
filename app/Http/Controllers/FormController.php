<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DynamicForm;

class FormController extends Controller
{
    public function index()
    {
        $forms = DynamicForm::all();
        return view('admin.forms.index', compact('forms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'target_role' => 'required|in:sponsor,student',
            'field_labels.*' => 'required|string',
            'field_types.*' => 'required|in:text,textarea,dropdown,file',
        ]);

        $fields = [];
        if ($request->field_labels) {
            foreach ($request->field_labels as $index => $label) {
                $fields[] = [
                    'label' => $label,
                    'type' => $request->field_types[$index],
                    'required' => true,
                ];
            }
        }

        DynamicForm::create([
            'title' => $request->title,
            'description' => $request->description,
            'target_role' => $request->target_role,
            'fields' => $fields,
        ]);

        return back()->with('success', 'Dynamic form created successfully.');
    }

    public function destroy(DynamicForm $form)
    {
        $form->delete();
        return back()->with('success', 'Form deleted.');
    }
}
