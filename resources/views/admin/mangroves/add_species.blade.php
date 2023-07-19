@extends('layouts.admin')

@section('title', 'Eco Bohol - Add Species Record')

@section('content')

    <div class="common-background flex-1 pt-5 px-5 pb-40 overflow-y-auto">
        <div class="flex justify-between md:mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-lg md:text-2xl">{{ ucfirst($action) }} Species Record</h1>
            <a href="/admin/manage-speciesrecords"
                class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24  bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <form
            action={{ '/admin/manage-speciesrecords/' . $action }}{{ $speciesrecord ? '?species_id=' . $speciesrecord->species_id : '' }}
            method="POST" enctype="multipart/form-data">
            @if ($action == 'update')
                @method('patch')
            @else
                @method('put')
            @endif
            @csrf
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 font-bold mb-2">
                        <h6>Species</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col md:w-auto w-full">
                        <label for="mangrove_id">Mangrove ID</label>
                        <input type="text" class="common-input" name="mangrove_id"
                            value="{{ old('mangrove_id', $speciesrecord ? $speciesrecord->mangrove_id : null) }}" required>
                        @error('mangrove_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 font-bold mb-2">
                        <h6>Species Name</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col md:flex-row">
                        <div class="flex flex-col mb-2 md:mb-0">
                            <label for="scientific_name">Scientific name</label>
                            <input type="text" class="common-input" name="scientific_name"
                                value=" {{ old('scientific_name', $speciesrecord ? $speciesrecord->scientific_name : null) }}"
                                required>
                            @error('scientific_name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col">
                            <label for="common_name">Common name</label>
                            <input type="text" class="common-input" name="common_name"
                                value=" {{ old('common_name', $speciesrecord ? $speciesrecord->common_name : null) }}"
                                required>
                            @error('common_name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 font-bold mb-2">
                        <h6>Taxonomy</h6>
                    </div>
                    <div class="grid lg:grid-cols-3 md:grid-cols-2">
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="kingdom">Kingdom</label>
                            <input type="text" class="common-input" name="kingdom"
                                value="{{ old('kingdom', $speciesrecord ? $speciesrecord->kingdom : null) }}" required>
                            @error('kingdom')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="phylum">Phylum</label>
                            <input type="text" class="common-input" name="phylum"
                                value="{{ old('phylum', $speciesrecord ? $speciesrecord->phylum : null) }}" required>
                            @error('phylum')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="class">Class</label>
                            <input type="text" class="common-input" name="class"
                                value="{{ old('class', $speciesrecord ? $speciesrecord->class : null) }}" required>
                            @error('class')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="order">Order</label>
                            <input type="text" class="common-input" name="order"
                                value="{{ old('order', $speciesrecord ? $speciesrecord->order : null) }}" required>
                            @error('order')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="family">Family</label>
                            <input type="text" class="common-input" name="family"
                                value="{{ old('family', $speciesrecord ? $speciesrecord->family : null) }}" required>
                            @error('family')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="genus">Genus</label>
                            <input type="text" class="common-input" name="genus"
                                value="{{ old('genus', $speciesrecord ? $speciesrecord->genus : null) }}" required>
                            @error('genus')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 font-bold mb-2">
                        <h6>Species Decription</h6>
                    </div>
                    <div class="flex flex-col md:space-y-2">
                        <div class="grid md:grid-cols-1 lg:grid-cols-2">
                            <div class="md:ml-10 flex flex-col md:w-96">
                                <label for="species_descrp">Species Description</label>
                                <textarea name="species_descrp" class="common-input h-28" required>{{ old('species_descrp', $speciesrecord ? $speciesrecord->species_descrp : null) }}</textarea>
                                @error('species_descrp')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col md:w-96">
                                <label for="propagule_descrp">Propagule Description</label>
                                <textarea name="propagule_descrp" class="common-input h-28"required>{{ old('propagule_descrp', $speciesrecord ? $speciesrecord->propagule_descrp : null) }}</textarea>
                                @error('propagule_descrp')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="grid md:grid-cols-1 lg:grid-cols-2">
                            <div class="md:ml-10 flex flex-col md:w-96">
                                <label for="flower_descr">Flower Description</label>
                                <textarea name="flower_descrp" class="common-input h-28" required>{{ old('flower_descrp', $speciesrecord ? $speciesrecord->flower_descrp : null) }}</textarea>
                                @error('flower_descrp')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col md:w-96">
                                <label for="leaves_descr">Leaves Description</label>
                                <textarea name="leaves_descrp" class="common-input h-28" required>{{ old('leaves_descrp', $speciesrecord ? $speciesrecord->leaves_descrp : null) }}</textarea>
                                @error('leaves_descrp')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 font-bold mb-2">
                        <h6>Other Details</h6>
                    </div>
                    <div class="flex flex-col md:space-y-2">
                        <div class="grid md:grid-cols-1 lg:grid-cols-2">
                            <div class="md:ml-10 flex flex-col md:w-96">
                                <label for="style">Style Description</label>
                                <textarea name="style" class="common-input h-16" required>{{ old('style', $speciesrecord ? $speciesrecord->style : null) }}</textarea>
                                @error('style')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col md:w-96">
                                <label for="zonation">Zonation Description</label>
                                <textarea name="zonation" class="common-input h-16" required>{{ old('zonation', $speciesrecord ? $speciesrecord->zonation : null) }}</textarea>
                                @error('zonation')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="grid md:grid-cols-1 lg:grid-cols-2">
                            <div class="md:ml-10 flex flex-col md:w-96">
                                <label for="relev_com">Relevance to the Community</label>
                                <textarea name="relev_com" class="common-input h-20" required>{{ old('relev_com', $speciesrecord ? $speciesrecord->relev_com : null) }}</textarea>
                                @error('relev_com')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Species Images</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="species_img">Species Image</label>
                        <input type="file" class="common-input w-64" name="species_img[]" id="image" multiple
                            accept="image/*">
                        @error('species_img')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Propagule Images</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="propagule_img">Propagule Image</label>
                        <input type="file" class="common-input w-64" name="propagule_img[]" multiple
                            accept="image/*">
                        @error('propagule_img')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Flower Images</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="flower_img">Flower Image</label>
                        <input type="file" class="common-input w-64" name="flower_img[]" multiple accept="image/*">
                        @error('flower_img')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <img src="img.jpeg" alt="">
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Leaves Images</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="leaves_img">Leaves Image</label>
                        <input type="file" class="common-input w-64" name="leaves_img[]" multiple accept="image/*">
                        @error('leaves_img')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <img src="img.jpeg" alt="">
                    </div>
                </div>
            </div>

            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Conservation Status</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="conserv_status">Status</label>
                        <input type="hidden" id="selectedConserv_status"
                            value="{{ $speciesrecord ? $speciesrecord->conserv_status : null }}">
                        <select type="text" class="common-input" name="conserv_status" id="conserv_status" required>
                            <option value="">Select Status</option>
                            {{-- <option value="Extinct"
                                {{ $speciesrecord ? ($speciesrecord->conserv_status == 'Extinct' ? 'selected' : null) : null }}>
                                Extinct</option>
                            <option value="Extinct in the Wild"
                                {{ $speciesrecord ? ($speciesrecord->conserv_status == 'Extinct in the Wild' ? 'selected' : null) : null }}>
                                Extinct in the Wild</option>
                            <option value="Critically Endangered"
                                {{ $speciesrecord ? ($speciesrecord->conserv_status == 'Critically Endangered' ? 'selected' : null) : null }}>
                                Critically Endangered</option>
                            <option value="Endangered"
                                {{ $speciesrecord ? ($speciesrecord->conserv_status == 'Endangered' ? 'selected' : null) : null }}>
                                Endangered</option>
                            <option value="Vulnerable"
                                {{ $speciesrecord ? ($speciesrecord->conserv_status == 'Vulnerable' ? 'selected' : null) : null }}>
                                Vulnerable</option>
                            <option value="Near Threatened"
                                {{ $speciesrecord ? ($speciesrecord->conserv_status == 'Near Threatened' ? 'selected' : null) : null }}>
                                Near Threatened</option>
                            <option value="Least Concern"
                                {{ $speciesrecord ? ($speciesrecord->conserv_status == 'Least Concern' ? 'selected' : null) : null }}>
                                Least Concern</option>
                            <option value="Data Deficient"
                                {{ $speciesrecord ? ($speciesrecord->conserv_status == 'Data Deficient' ? 'selected' : null) : null }}>
                                Data Deficient</option>
                            <option value="Not Evaluated"
                                {{ $speciesrecord ? ($speciesrecord->conserv_status == 'Not Evaluated' ? 'selected' : null) : null }}>
                                Not Evaluated</option> --}}
                            <option value="Extinct"
                                {{ old('conserv_status') == 'Extinct' || ($speciesrecord && $speciesrecord->conserv_status == 'Extinct') ? 'selected' : '' }}>
                                Extinct
                            </option>
                            <option value="Extinct in the Wild"
                                {{ old('conserv_status') == 'Extinct in the Wild' || ($speciesrecord && $speciesrecord->conserv_status == 'Extinct in the Wild') ? 'selected' : '' }}>
                                Extinct in the Wild
                            </option>
                            <option value="Critically Endangered"
                                {{ old('conserv_status') == 'Critically Endangered' || ($speciesrecord && $speciesrecord->conserv_status == 'Critically Endangered') ? 'selected' : '' }}>
                                Critically Endangered
                            </option>
                            <option value="Endangered"
                                {{ old('conserv_status') == 'Endangered' || ($speciesrecord && $speciesrecord->conserv_status == 'Endangered') ? 'selected' : '' }}>
                                Endangered
                            </option>
                            <option value="Vulnerable"
                                {{ old('conserv_status') == 'Vulnerable' || ($speciesrecord && $speciesrecord->conserv_status == 'Vulnerable') ? 'selected' : '' }}>
                                Vulnerable
                            </option>
                            <option value="Near Threatened"
                                {{ old('conserv_status') == 'Near Threatened' || ($speciesrecord && $speciesrecord->conserv_status == 'Near Threatened') ? 'selected' : '' }}>
                                Near Threatened
                            </option>
                            <option value="Least Concern"
                                {{ old('conserv_status') == 'Least Concern' || ($speciesrecord && $speciesrecord->conserv_status == 'Least Concern') ? 'selected' : '' }}>
                                Least Concern
                            </option>
                            <option value="Data Deficient"
                                {{ old('conserv_status') == 'Data Deficient' || ($speciesrecord && $speciesrecord->conserv_status == 'Data Deficient') ? 'selected' : '' }}>
                                Data Deficient
                            </option>
                            <option value="Not Evaluated"
                                {{ old('conserv_status') == 'Not Evaluated' || ($speciesrecord && $speciesrecord->conserv_status == 'Not Evaluated') ? 'selected' : '' }}>
                                Not Evaluated
                            </option>
                        </select>
                        @error('conserv_status')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <select type="text" class="common-input" name="status" id="status" hidden>
                            <option value="Active" selected></option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="flex py-10 px-5 space-x-2">
                <button type="submit" class="primary-btn w-24">Submit</button>
                <a href='/admin/manage-speciesrecords'
                    class="w-24 bg-gray-500 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Cancel</a>
            </div>
        </form>
    </div>

@stop
