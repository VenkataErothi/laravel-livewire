<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use App\Models\Student;
use Livewire\Component;

class StudentShow extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name, $email, $phone, $student_id;
    public $search = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:10',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }
     
    public function save()
    {

        $validatedData = $this->validate([
        'name'=>'required|unique:students',
        'email'=>'required|email|unique:students',
        'phone'=>'required|numeric|unique:students',

        ]);
        Student::create($validatedData);
        session()->flash('message','Student Added Successfully');
        $this->emit('studentSave');
    }

    public function editStudent($student_id)
    {
        $student = Student::find($student_id);
        if($student){

            $this->student_id = $student->id;
            $this->name = $student->name;
            $this->email = $student->email;
            $this->phone = $student->phone;
        }else{
            return redirect()->to('/students');
        }
    }

    public function update()
    {
        $validatedData = $this->validate();

        Student::where('id',$this->student_id)->update([
           
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone']
        ]);
        session()->flash('message','Student Updated Successfully');
        $this->resetInput();
        $this->emit('studentUpdate');
    }

    public function deleteStudent($student_id) 
    {
        $this->student_id = $student_id;
    }

    public function destroy()
    {
        Student::find($this->student_id)->delete();
        session()->flash('message','Student Deleted Successfully');
        $this->emit('studentDestroy');
    }

  public function closeModal()
    {
    $this->reset(['name', 'email','phone']);
    $this->dispatchBrowserEvent('close-modal');

    }

    public function resetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
    }

    public function render()
    {
        $students = Student::where('name', 'like', '%'.$this->search.'%')->orderBy('id','ASC')->paginate(4);
        return view('livewire.student-show', ['students' => $students]);
    }

}