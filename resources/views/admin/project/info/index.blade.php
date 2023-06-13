@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <x-admin-menu :page="'projecten'" />
            @if($project->image)
            <img src="/images/projects/{{ $project->image }}" class="img-thumbnail mt-3" alt="...">
            <form action="{{ route('admin.projects.destroy.image', $project) }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger mt-2 w-100">Verwijder afbeelding</button>
            </form>
            @endif
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row">
                <h1>{{ __('Informatie') }}</h1>
                <x-project-option-dropdown :project="$project" />
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('admin.projects.edit.info', $project ) }}">Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('admin.projects.users.index', $project) }}">Gebruikers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" aria-current="page" href="{{ route('admin.projects.tasks.open', $project) }}">Taken</a>
                </li>
                @if($project->company_id)
                <li class="nav-item">
                    <a class="nav-link text-dark" aria-current="page" href="{{route('admin.projects.company.index', $project)}}">Bedrijfsgegevens</a>
                </li>
                @endif
            </ul>
            <div class="card mb-5">

                <div class="card-body">
                    @if (session('status'))
                    <x-alert />
                    @endif
                    <form method="POST" action="{{ route('admin.projects.update.info', $project) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <x-errored-label for="title" :value="__('Titel')" :field="'title'" />
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="title" autofocus value="{{ old('title') ?? $project->title }}">
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="introduction" :value="__('Introductie')" :field="'introduction'" />
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="introduction">{{ old('introduction') ?? $project->introduction }}</textarea>
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="descriptio" :value="__('Beschrijving')" :field="'description'" />
                            <div class="medium-editor">
                                <textarea class="form-control large" id="editor" rows="7" name="description">{{ old('description') ?? $project->description }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="image" :value="__('Afbeelding')" :field="'image'" />
                            <input class="form-control" type="file" id="input" name="image">
                        </div>
                        <div class="d-flex mb-2" id="preview">
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <x-errored-label for="start_date" :value="__('Start datum')" :field="'start_date'" />
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') ?? $project->start_date }}">
                            </div>
                            <div class="col">
                                <x-errored-label for="end_date" :value="__('Eind datum')" :field="'end_date'" />
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') ?? $project->end_date }}">
                            </div>
                        </div>
                        <x-errored-label for="user" :value="__('Bedrijf (optioneel)')" :field="'company'" />
                        <select class="form-select mb-3" name="company" id="company">
                            <option {{ old('company') ? '' : 'selected' }} value="{{ NULL }}">Selecteer een bedrijf</option>
                            @foreach($companies as $company)
                            <option {{  $project->company_id == $company->id ? 'selected' : '' }} value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        <div class="mb-3 employees">

                        </div>


                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.projects.index') }}" class=" btn btn-link text-dark text-decoration-none">Annuleren</a>
                            <button class="btn btn-success mb-3">Project bijwerken</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="{{ asset('/js/editor.js') }}" defer></script>
<script>
    const companySelect = document.getElementById('company')
    const employeeDiv = document.querySelector('.employees')
    const form = document.getElementById('form-project')
    const token = document.querySelector('meta[name="csrf-token"]').content;
    if (companySelect.value) {
        fetch(`/admin/companies/${companySelect.value}/employee`, {
            method: "post",
            mode: "same-origin",
            headers: {
                "Content-Type": "application/json; charset=utf-8",
                "X-CSRF-TOKEN": token,
            },
            body: JSON.stringify({

            })
        }).then((res) => {
            return res.json();
        }).then((res) => {
            const label = document.createElement('label')
            label.innerText = 'Contactpersoon'
            label.className = 'form-label'
            label.id = 'employee_label'
            const selectList = document.createElement('select');
            selectList.id = 'employees'
            selectList.className = 'form-select mb-3'
            selectList.name = 'employee'

            res.forEach(employee => {
                var option = document.createElement('option');
                option.value = employee.id;
                option.text = employee.name;
                option.selected = '{{ $project->employee_id }}' == employee.id ? true : false;
                selectList.appendChild(option);
            });

            employeeDiv.appendChild(label);
            employeeDiv.appendChild(selectList);
        })
    }

    companySelect.addEventListener('change', (e) => {
        e.preventDefault();
        if (document.getElementById('employees')) {
            document.getElementById('employees').remove()
            document.getElementById('employee_label').remove()
        }
        if (e.target.value) {
            fetch(`/admin/companies/${e.target.value}/employee`, {
                method: "post",
                mode: "same-origin",
                headers: {
                    "Content-Type": "application/json; charset=utf-8",
                    "X-CSRF-TOKEN": token,
                },
                body: JSON.stringify({

                })
            }).then((res) => {
                return res.json();
            }).then((res) => {
                const label = document.createElement('label')
                label.innerText = 'Contactpersoon'
                label.className = 'form-label'
                label.id = 'employee_label'
                const selectList = document.createElement('select');
                selectList.id = 'employees'
                selectList.className = 'form-select mb-3'
                selectList.name = 'employee'

                res.forEach(employee => {
                    var option = document.createElement('option');
                    option.value = employee.id;
                    option.text = employee.name;
                    selectList.appendChild(option);
                });

                employeeDiv.appendChild(label);
                employeeDiv.appendChild(selectList);
            })
        }
    })
</script>
@endsection