<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;

class Crud extends Component
{

    public $students, $name, $email, $mobile, $student_id;
    public $isModalOpen = 0;

    public function render()
    {
        $this->students = Student::all();
        return view('livewire.crud');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm()
    {
        $this->name  = '';
        $this->email = '';
        $this->mobile = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
        ]);

        Student::updateOrCreate(['id' => $this->student_id], [ // if id가 존재할경우 []실행, 없을 경우 새로 만듬
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
        ]);

        session()->flash('message', $this->student_id ? 'Student updated.' : 'Student created.'); // 다음 요청에서만 사용하기 위한 값을 세션에 저장함

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id); // 쿼리의 첫번째 결과를 반환하지만, 결과를 찾을 수 없을 때에는 에러를 던짐
        $this->student_id =  $student->id;
        $this->name = $student->name;
        $this->email = $student->email;
        $this->mobile = $student->mobile;

        $this->openModalPopover();
    }

    public function delete($id)
    {
        Student::find($id)->delete();
        session()->flash('message', 'Studnet deleted.');
    }
}
