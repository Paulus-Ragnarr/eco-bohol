@extends('layouts.master')

@section('title', 'Eco Bohol - Register Stakeholder')

@section('header')

@stop

@section('content')
    <div>
        <div id="success-modal" class="modal hidden fixed inset-0 z-10 overflow-y-auto">
            <div class="modal-container mx-auto sm:w-4/5 lg:w-3/5 xl:w-1/2 p-8 text-left bg-white rounded-lg shadow-lg z-50">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-2xl leading-6 font-medium text-gray-900">Registration Sent!</h3>
                    </div>

                    <div class="modal-body mt-4">
                        <p class="text-gray-700 text-1xl">Please wait for approval, Thank you!</p>
                    </div>
                    <div class="modal-footer flex justify-end mt-8">
                        <button
                            class="modal-close px-4 py-2 bg-gray-500 text-white font-bold rounded-lg hover:bg-gray-600 focus:outline-none focus:shadow-outline-gray"
                            onclick="closeModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col justify-center items-center h-screen object-cover"
            style="background-image: url('/static/img/stakeholdercover.jpg'); background-size: cover; background-position: center;">
            <form action="/stakeholder/register" method="POST"
                class="justify-center items-center w-1/2 bg-green-900/70 shadow-xl rounded-xl p-5"
                onsubmit="return submitForm(event)" enctype="multipart/form-data">
                <h1 class="text-4xl mb-10 text-center font-bold text-white">Register as Stakeholder</h1>
                @csrf
                <div class="grid md:grid-cols-3 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="stakeholder_email" id="stakeholder_email"
                            class="block py-2.5 px-0 w-full text-md text-white bg-transparent border-0 border-b-2 border-white appearance-none dark:text-white dark:border-white dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white peer"
                            placeholder=" " value="{{ old('stakeholder_email') }}" required />
                        <label for="stakeholder_email"
                            class="peer-focus:font-medium absolute text-xl text-white dark:text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                            address</label>
                        @error('stakeholder_email')
                            <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="password" name="stakeholder_pass" id="stakeholder_pass"
                            class="block py-2.5 px-0 w-full text-md text-white bg-transparent border-0 border-b-2 border-white appearance-none dark:text-white dark:border-white dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white peer"
                            placeholder=" " required />
                        <label for="stakeholder_pass"
                            class="peer-focus:font-medium absolute text-xl text-white dark:text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                        @error('stakeholder_pass')
                            <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="password" name="stakeholder_pass_confirmation" id="confirmNewPasswordInput"
                            class="block py-2.5 px-0 w-full text-md text-white bg-transparent border-0 border-b-2 border-white appearance-none dark:text-white dark:border-white dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white peer"
                            placeholder=" " required />
                        <label for="confirm_password"
                            class="peer-focus:font-medium absolute text-xl text-white dark:text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm
                            Password</label>
                        @error('stakeholder_pass')
                            <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="first_name" id="first_name"
                            class="block py-2.5 px-0 w-full text-md text-white bg-transparent border-0 border-b-2 border-white appearance-none dark:text-white dark:border-white dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white peer"
                            placeholder=" " value="{{ old('first_name') }}" required />
                        <label for="first_name"
                            class="peer-focus:font-medium absolute text-xl text-white dark:text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First
                            name</label>
                        @error('first_name')
                            <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="middle_name" id="middle_name"
                            class="block py-2.5 px-0 w-full text-md text-white bg-transparent border-0 border-b-2 border-white appearance-none dark:text-white dark:border-white dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white peer"
                            placeholder=" " value="{{ old('middle_name') }}" />
                        <label for="middle_name"
                            class="peer-focus:font-medium absolute text-xl text-white dark:text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Middle
                            name (optional)</label>
                            @error('middle_name')
                            <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="last_name" id="last_name"
                            class="block py-2.5 px-0 w-full text-md text-white bg-transparent border-0 border-b-2 border-white appearance-none dark:text-white dark:border-white dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white peer"
                            placeholder=" " value="{{ old('last_name') }}" required />
                        <label for="last_name"
                            class="peer-focus:font-medium absolute text-xl text-white dark:text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last
                            name</label>
                        @error('last_name')
                            <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="suffix" id="suffix"
                            class="block py-2.5 px-0 w-full text-md text-white bg-transparent border-0 border-b-2 border-white appearance-none dark:text-white dark:border-white dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white peer"
                            placeholder=" " value="{{ old('suffix') }}" />
                        <label for="suffix"
                            class="peer-focus:font-medium absolute text-xl text-white dark:text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Suffix
                            (optional)</label>
                            @error('suffix')
                            <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="tel" name="contact_num" id="contact_num"
                            class="block py-2.5 px-0 w-full text-md text-white bg-transparent border-0 border-b-2 border-white appearance-none dark:text-white dark:border-white dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white peer"
                            placeholder=" " value="{{ old('contact_num') }}" required />
                        <label for="contact_num"
                            class="peer-focus:font-medium absolute text-xl text-white dark:text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Contact</label>
                        @error('contact_num')
                            <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="position" id="position"
                            class="block py-2.5 px-0 w-full text-md text-white bg-transparent border-0 border-b-2 border-white appearance-none dark:text-white dark:border-white dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white peer"
                            placeholder=" " value="{{ old('position') }}" />
                        <label for="position"
                            class="peer-focus:font-medium absolute text-xl text-white dark:text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Position
                            (optional)</label>
                    </div> --}}
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="org_name" id="org_name"
                            class="block py-2.5 px-0 w-full text-md text-white bg-transparent border-0 border-b-2 border-white appearance-none dark:text-white dark:border-white dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white peer"
                            placeholder=" " value="{{ old('org_name') }}" required />
                        <label for="org_name"
                            class="peer-focus:font-medium absolute text-xl text-white dark:text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Organization
                            Name</label>
                        @error('org_name')
                            <div class="alert alert-danger text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6">
                        <label for="stakeholder_type" class="text-white">Type</label>
                        <select class="login-input text-gray-500" name="stakeholder_type" id="stakeholder_type"
                            value="{{ old('stakeholder_type') }}" required>
                            <option value="" selected>Select a type</option>
                            <option value="Non Government Organization"
                                {{ old('stakeholder_type') == 'Non Government Organization' ? 'selected' : '' }}>Non
                                Government Organization</option>
                            <option value="Local Government Unit"
                                {{ old('stakeholder_type') == 'Local Government Unit' ? 'selected' : '' }}>Local Government
                                Unit</option>
                            <option value="Government Agency"
                                {{ old('stakeholder_type') == 'Government Agency' ? 'selected' : '' }}>Government Agency
                            </option>
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6">
                        <label class="block text-lg font-medium text-white" for="endorsement_letter">Endorsement
                            Letter</label>
                        <input type="file"
                            class="block w-full text-sm border border-gray-100 rounded-lg cursor-pointer bg-gray-200 focus:outline-none text-gray-500 dark:placeholder-gray-200 common-input"
                            name="endorsement_letter[]" multiple id="endorsement_letter" required>
                        <div class="mt-1 text-sm text-white">PDF, PNG, JPEG</div>
                    </div>
                </div>
                <button class="primary-btn w-full text-white mt-4" type="submit">Register</button>
            </form>
            <a href="/" class="mt-3 text-white font-bold text-xl">Back to Homepage</a>
        </div>
    </div>
    <script>
        @if (Session::has('success'))
            document.getElementById('success-modal').classList.remove('hidden');
        @endif

        function closeModal() {
            document.getElementById('success-modal').classList.add('hidden');
        }
    </script>

@stop
