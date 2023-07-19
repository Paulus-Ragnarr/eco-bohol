@extends('layouts.admin')


@section('title', 'Eco Bohol - Add Plantation Record')


@section('content')

    <div class="common-background flex-1 pt-5 px-5 pb-40 overflow-y-auto">
        <div class="flex justify-between mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-2xl">{{ ucfirst($action) }} Plantation Record</h1>
            <a href='/admin/manage-plantations'
                class="w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <form
            action={{ '/admin/manage-plantations/' . $action }}{{ $plantation ? '?plantation_id=' . $plantation->plantation_id : '' }}
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
                        <h6>Plantation Code</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col md:w-auto w-full">
                        <label for="unique_code">Unique Code</label>
                        <input class="common-input" type="text" name="unique_code"
                            value="{{ old('unique_code', $plantation ? $plantation->unique_code : null) }}" required>
                        @error('unique_code')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 font-bold mb-2">
                        <h6>Assign Contractor</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col md:w-auto w-full">
                        <label for="manager_id">Manager</label>
                        <select class="common-input" type="text" name="manager_id" required>
                            <option value="">Select Contractor</option>
                            @foreach ($managers as $manager)
                                {{-- <option value="{{ $manager->manager_id }}"
                                    {{ $plantation ? ($plantation->manager_id == $manager->user_id ? 'selected' : null) : null }}>
                                    {{ $manager->name }}</option> --}}
                                <option value="{{ $manager->user_id }}"
                                    {{ old('manager_id') == $manager->user_id || ($plantation && $plantation->manager_id == $manager->user_id) ? 'selected' : '' }}>
                                    {{ $manager->name }}</option>
                            @endforeach
                        </select>
                        @error('manager_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 font-bold mb-2">
                        <h6>Location</h6>
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3">
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            {{-- <label for="region">Region</label>
                            <input type="hidden" id="selectedRegion"
                                {{ $plantation ? 'value=' . $plantation->region : null }}>
                            <select class="common-input" type="text" name="region" id='region' required>
                                <option value="">Select Region</option>
                            </select> --}}
                            <label for="region">Region</label>
                            <select class="common-input" type="text" name="region" id='region' required>
                                <option value="Central Visayas"
                                    {{ old('region') == 'Central Visayas' || ($plantation && $plantation->region == 'Central Visayas') ? 'selected' : '' }}>
                                    Central Visayas
                                </option>
                            </select>
                            @error('region')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="district">District</label>
                            <select class="common-input" type="text" name="district" id='district' required>
                                <option value="">Select District</option>
                                {{-- <option value="1"
                                    {{ $plantation ? ($plantation->district == '1' ? 'selected' : null) : null }}>District
                                    1
                                </option>
                                <option value="2"
                                    {{ $plantation ? ($plantation->district == '2' ? 'selected' : null) : null }}>District
                                    2</option>
                                <option value="3"
                                    {{ $plantation ? ($plantation->district == '3' ? 'selected' : null) : null }}>District
                                    3</option> --}}
                                <option value="1"
                                    {{ old('district') == '1' || ($plantation && $plantation->district == '1') ? 'selected' : '' }}>
                                    District
                                    1
                                </option>
                                <option value="2"
                                    {{ old('district') == '2' || ($plantation && $plantation->district == '2') ? 'selected' : '' }}>
                                    District
                                    2</option>
                                <option value="3"
                                    {{ old('district') == '3' || ($plantation && $plantation->district == '3') ? 'selected' : '' }}>
                                    District
                                    3</option>
                            </select>
                            @error('district')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="plantation_address">Plantation Address</label>
                            <input class="common-input w-80" type="text" name="plantation_address"
                                value='{{ old('plantation_address', $plantation ? $plantation->plantation_address : null) }}'
                                required>
                            @error('plantation_address')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 font-bold mb-2">
                        <h6>Environment and Natural Resources Offices</h6>
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-row">
                        <div class="md:ml-10 flex flex-col">
                            <label for="penro">PENRO</label>
                            <input class="common-input w-75" type="text" name="penro"
                                value=' {{ old('penro', $plantation ? $plantation->penro : 'Bohol') }}' required>
                            @error('penro')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 grid grid-col">
                            <label for="cenro">CENRO</label>
                            <input class="common-input w-75" type="text" name="cenro"
                                value='{{ old('cenro', $plantation ? $plantation->cenro : null) }}' required>
                            @error('cenro')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Plantation Details</h6>
                    </div>
                    <div>
                        <div class="grid sm:grid-cols-3 md:grid-cols-1 lg:grid-cols-3 mb-5 gap-2">
                            <div class="md:ml-10 flex flex-col">
                                <label for="component">Component</label>
                                <input class="common-input w-75" type="text" name="component"
                                    value='{{ old('component', $plantation ? $plantation->component : null) }}' required>
                                @error('component')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col">
                                <label for="commodity">Commodity</label>
                                <input class="common-input w-75" type="text" name="commodity"
                                    value='{{ old('commodity', $plantation ? $plantation->commodity : 'Mangrove') }}'
                                    required>
                                @error('commodity')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col">
                                <label for="date_started">Date Started</label>
                                <input class="common-input w-75" type="date" name="date_started"
                                    value='{{ old('date_started', $plantation ? $plantation->date_started : null) }}'
                                    required>
                                @error('date_started')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col">
                                <label for="total_area">Total Area(ha)</label>
                                <input class="common-input w-75" type="text" name="total_area"
                                    value='{{ old('total_area', $plantation ? $plantation->total_area : null) }}'
                                    required>
                                @error('total_area')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col">
                                <label for="tenure">Tenure</label>
                                <input class="common-input w-75" type="text" name="tenure"
                                    value='{{ old('tenure', $plantation ? $plantation->tenure : null) }}' required>
                                @error('tenure')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col">
                                <label for="fund_source">Fund Source</label>
                                <input class="common-input w-75" type="text" name="fund_source"
                                    value='{{ old('fund_source', $plantation ? $plantation->fund_source : null) }}'
                                    required>
                                @error('fund_source')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col">
                                <label for="target_loa">Target Loa(ha)</label>
                                <input class="common-input w-75" type="number" name="target_loa" min="1"
                                    value='{{ old('target_loa', $plantation ? $plantation->target_loa : null) }}'
                                    required>
                                @error('target_loa')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col">
                                <label for="no_loa">No Loa</label>
                                <input class="common-input w-75" type="number" name="no_loa" min="1"
                                    value='{{ old('no_loa', $plantation ? $plantation->no_loa : null) }}' required>
                                @error('no_loa')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex">
                                <div class="md:ml-10 flex flex-col">
                                    <label for="species">Species</label>
                                    <select class="common-input w-80"type="text" name="species[]" id="species"
                                        multiple multiple-search="true" multiselect-select-all="true">
                                        @foreach ($speciesrecord as $mangrove)
                                            <option value="{{ $mangrove->common_name }}"
                                                {{ in_array($mangrove->common_name, $SelectedSpecies) ? 'selected' : '' }}>
                                                {{ $mangrove->common_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('species')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="md:ml-10 flex flex-col">
                                <label for="target_no">Target Number</label>
                                <input class="common-input w-75" type="number" name="target_no" min="1"
                                    value='{{ old('target_no', $plantation ? $plantation->target_no : null) }}' required>
                                @error('target_no')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col">
                                <label for="initial_no">Initial Number</label>
                                <input class="common-input w-75" type="number" name="initial_no" min="0"
                                    value='{{ old('initial_no', $plantation ? $plantation->initial_no : 0) }}' required>
                                @error('initial_no')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col">
                                <label for="density_ha">Density (ha)</label>
                                <input class="common-input w-75" type="number" name="density_ha" min="1"
                                    value='{{ old('density_ha', $plantation ? $plantation->density_ha : 2500) }}'
                                    required>
                                @error('density_ha')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col">
                                <label for="current_planted">Current No. Planted</label>
                                <input class="common-input w-75" type="number" name="current_planted" min="0"
                                    value='{{ old('current_planted', $plantation ? $plantation->current_planted : 0) }}'
                                    required>
                                @error('current_planted')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:ml-10 flex flex-col">
                                <label for="status">Status</label>
                                <select class="common-input w-75" type="text" name="status" id="status" required>
                                    {{-- <option value="Ongoing"
                                        {{ $plantation ? ($plantation->status == 'Ongoing' ? 'selected' : null) : null }}>
                                        Ongoing</option> --}}
                                    {{-- <option value="Completed"
                                        {{ $plantation ? ($plantation->status == 'Completed' ? 'selected' : null) : null }}>
                                        Completed</option> --}}
                                    <option value="Ongoing"
                                        {{ old('status') == 'Ongoing' || ($plantation && $plantation->status == 'Ongoing') ? 'selected' : '' }}>
                                        Ongoing</option>
                                    <option value="Completed"
                                        {{ old('status') == 'Completed' || ($plantation && $plantation->status == 'Completed') ? 'selected' : '' }}>
                                        Completed</option>
                                </select>
                                @error('status')
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
                        <h6>Geo Location</h6>
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-row">
                        <div class="md:ml-10 flex flex-col">
                            <label for="latitude">Latitude</label>
                            <input class="common-input w-75" type="text" name="latitude"
                                value='{{ old('latitude', $plantation ? $plantation->latitude : null) }}'
                                {{ $location_for ? 'disabled' : null }}>
                            @error('latitude')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col">
                            <label for="longitude">Longitude</label>
                            <input class="common-input w-75" type="text" name="longitude"
                                value='{{ old('longitude', $plantation ? $plantation->longitude : null) }}'
                                {{ $location_for ? 'disabled' : null }}>
                            @error('longitude')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Letter of Agreement</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="loa_attachment">Loa Attachment</label>
                        <input class="common-input w-75" type="file" name="loa_attachment[]" multiple>
                        @error('loa_attachment')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($plantation)
                        <div class="md:ml-10 mt-5 flex">
                            <span class="flex-initial p-3 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Attachments: </span>
                                <span class="font-bold">
                                    @foreach ($plantation->loa_attachment as $attachment)
                                        @if ($attachment->attachmentFor == 'loa_attachment')
                                            <a href="{{ ' /storage/' . $attachment->attachment }}"
                                                class="text-blue-400
                                    hover:text-blue-600">{{ $attachment->attachmentFilename }},
                                            </a>
                                        @endif
                                    @endforeach
                                </span>
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="md:w-1/6 w-full mb-2 font-bold">
                        <h6>Remarks</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col w-full mt-2 md:w-1/2">
                        <textarea class="common-input h-40" name="remark">{{ old('remark', $plantation ? $plantation->remark : null) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="flex py-10 px-5 space-x-2">
                <button type="submit" class="primary-btn w-24">Submit</button>
                <a href='/admin/manage-plantations'
                    class="w-24 bg-gray-500 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Cancel</a>
            </div>
        </form>
    </div>



    <script>
        var style = document.createElement('style');
        style.setAttribute("id", "multiselect_dropdown_styles");
        style.innerHTML = `
.multiselect-dropdown{
  display: inline-block;
  padding: 2px 5px 0px 5px;
  border-radius: 4px;
  border: solid 1px #ced4da;
  background-color: white;
  position: relative;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right .75rem center;
  background-size: 16px 12px;
}
.multiselect-dropdown span.optext, .multiselect-dropdown span.placeholder{
  margin-right:0.5em; 
  margin-bottom:2px;
  padding:1px 0; 
  border-radius: 4px; 
  display:inline-block;
}
.multiselect-dropdown span.optext{
  background-color:lightgray;
  padding:1px 0.75em; 
}
.multiselect-dropdown span.optext .optdel {
  float: right;
  margin: 0 -6px 1px 5px;
  font-size: 0.7em;
  margin-top: 2px;
  cursor: pointer;
  color: #666;
}
.multiselect-dropdown span.optext .optdel:hover { color: #c66;}
.multiselect-dropdown span.placeholder{
  color:#ced4da;
}
.multiselect-dropdown-list-wrapper{
  box-shadow: gray 0 3px 8px;
  z-index: 100;
  padding:2px;
  border-radius: 4px;
  border: solid 1px #ced4da;
  display: none;
  margin: -1px;
  position: absolute;
  top:0;
  left: 0;
  right: 0;
  background: white;
}
.multiselect-dropdown-list-wrapper .multiselect-dropdown-search{
  margin-bottom:5px;
}
.multiselect-dropdown-list{
  padding:2px;
  height: 15rem;
  overflow-y:auto;
  overflow-x: hidden;
}
.multiselect-dropdown-list::-webkit-scrollbar {
  width: 6px;
}
.multiselect-dropdown-list::-webkit-scrollbar-thumb {
  background-color: #bec4ca;
  border-radius:3px;
}

.multiselect-dropdown-list div{
  padding: 5px;
}
.multiselect-dropdown-list input{
  height: 1.15em;
  width: 1.15em;
  margin-right: 0.35em;  
}
.multiselect-dropdown-list div.checked{
}
.multiselect-dropdown-list div:hover{
  background-color: #ced4da;
}
.multiselect-dropdown span.maxselected {width:100%;}
.multiselect-dropdown-all-selector {border-bottom:solid 1px #999;}
`;
        document.head.appendChild(style);

        function MultiselectDropdown(options) {
            var config = {
                search: true,
                height: '15rem',
                placeholder: 'select',
                txtSelected: 'selected',
                txtAll: 'All',
                txtRemove: 'Remove',
                txtSearch: 'search',
                ...options
            };

            function newEl(tag, attrs) {
                var e = document.createElement(tag);
                if (attrs !== undefined) Object.keys(attrs).forEach(k => {
                    if (k === 'class') {
                        Array.isArray(attrs[k]) ? attrs[k].forEach(o => o !== '' ? e.classList.add(o) : 0) : (attrs[
                            k] !== '' ? e.classList.add(attrs[k]) : 0)
                    } else if (k === 'style') {
                        Object.keys(attrs[k]).forEach(ks => {
                            e.style[ks] = attrs[k][ks];
                        });
                    } else if (k === 'text') {
                        attrs[k] === '' ? e.innerHTML = '&nbsp;' : e.innerText = attrs[k]
                    } else e[k] = attrs[k];
                });
                return e;
            }


            document.querySelectorAll("select[multiple]").forEach((el, k) => {

                var div = newEl('div', {
                    class: 'multiselect-dropdown',
                    style: {
                        width: config.style?.width ?? el.clientWidth + 'px',
                        padding: config.style?.padding ?? ''
                    }
                });
                el.style.display = 'none';
                el.parentNode.insertBefore(div, el.nextSibling);
                var listWrap = newEl('div', {
                    class: 'multiselect-dropdown-list-wrapper'
                });
                var list = newEl('div', {
                    class: 'multiselect-dropdown-list',
                    style: {
                        height: config.height
                    }
                });
                var search = newEl('input', {
                    class: ['multiselect-dropdown-search'].concat([config.searchInput?.class ??
                        'form-control'
                    ]),
                    style: {
                        width: '100%',
                        display: el.attributes['multiselect-search']?.value === 'true' ? 'block' : 'none'
                    },
                    placeholder: config.txtSearch
                });
                listWrap.appendChild(search);
                div.appendChild(listWrap);
                listWrap.appendChild(list);

                el.loadOptions = () => {
                    list.innerHTML = '';

                    if (el.attributes['multiselect-select-all']?.value == 'true') {
                        var op = newEl('div', {
                            class: 'multiselect-dropdown-all-selector'
                        })
                        var ic = newEl('input', {
                            type: 'checkbox'
                        });
                        op.appendChild(ic);
                        op.appendChild(newEl('label', {
                            text: config.txtAll
                        }));

                        op.addEventListener('click', () => {
                            op.classList.toggle('checked');
                            op.querySelector("input").checked = !op.querySelector("input").checked;

                            var ch = op.querySelector("input").checked;
                            list.querySelectorAll(
                                    ":scope > div:not(.multiselect-dropdown-all-selector)")
                                .forEach(i => {
                                    if (i.style.display !== 'none') {
                                        i.querySelector("input").checked = ch;
                                        i.optEl.selected = ch
                                    }
                                });

                            el.dispatchEvent(new Event('change'));
                        });
                        ic.addEventListener('click', (ev) => {
                            ic.checked = !ic.checked;
                        });

                        list.appendChild(op);
                    }

                    Array.from(el.options).map(o => {
                        var op = newEl('div', {
                            class: o.selected ? 'checked' : '',
                            optEl: o
                        })
                        var ic = newEl('input', {
                            type: 'checkbox',
                            checked: o.selected
                        });
                        op.appendChild(ic);
                        op.appendChild(newEl('label', {
                            text: o.text
                        }));

                        op.addEventListener('click', () => {
                            op.classList.toggle('checked');
                            op.querySelector("input").checked = !op.querySelector("input")
                                .checked;
                            op.optEl.selected = !!!op.optEl.selected;
                            el.dispatchEvent(new Event('change'));
                        });
                        ic.addEventListener('click', (ev) => {
                            ic.checked = !ic.checked;
                        });
                        o.listitemEl = op;
                        list.appendChild(op);
                    });
                    div.listEl = listWrap;

                    div.refresh = () => {
                        div.querySelectorAll('span.optext, span.placeholder').forEach(t => div.removeChild(
                            t));
                        var sels = Array.from(el.selectedOptions);
                        if (sels.length > (el.attributes['multiselect-max-items']?.value ?? 5)) {
                            div.appendChild(newEl('span', {
                                class: ['optext', 'maxselected'],
                                text: sels.length + ' ' + config.txtSelected
                            }));
                        } else {
                            sels.map(x => {
                                var c = newEl('span', {
                                    class: 'optext',
                                    text: x.text,
                                    srcOption: x
                                });
                                if ((el.attributes['multiselect-hide-x']?.value !== 'true'))
                                    c.appendChild(newEl('span', {
                                        class: 'optdel',
                                        text: '🗙',
                                        title: config.txtRemove,
                                        onclick: (ev) => {
                                            c.srcOption.listitemEl.dispatchEvent(
                                                new Event('click'));
                                            div.refresh();
                                            ev.stopPropagation();
                                        }
                                    }));

                                div.appendChild(c);
                            });
                        }
                        if (0 == el.selectedOptions.length) div.appendChild(newEl('span', {
                            class: 'placeholder',
                            text: el.attributes['placeholder']?.value ?? config.placeholder
                        }));
                    };
                    div.refresh();
                }
                el.loadOptions();

                search.addEventListener('input', () => {
                    list.querySelectorAll(":scope div:not(.multiselect-dropdown-all-selector)").forEach(
                        d => {
                            var txt = d.querySelector("label").innerText.toUpperCase();
                            d.style.display = txt.includes(search.value.toUpperCase()) ? 'block' :
                                'none';
                        });
                });

                div.addEventListener('click', () => {
                    div.listEl.style.display = 'block';
                    search.focus();
                    search.select();
                });

                document.addEventListener('click', function(event) {
                    if (!div.contains(event.target)) {
                        listWrap.style.display = 'none';
                        div.refresh();
                    }
                });
            });
        }

        window.addEventListener('load', () => {
            MultiselectDropdown(window.MultiselectDropdownOptions);
        });
    </script>
    {{-- <script>
        let regionSelect = document.getElementById('region')
        let districtSelect = document.getElementById('district')
        regionSelect.addEventListener('change', function(event) {
            let districts = fetch(`https://psgc.gitlab.io/api/regions/${event.target.value}/districts`)
                .then(response => response.json())
                .then(data => {
                    for (let i = 0; i < data.length; i++) {
                        let option = document.createElement('option')
                        option.value = data[i].code
                        option.text = data[i].name
                        districtSelect.add(option)
                    }
                })
        })
        let selectedRegion = document.getElementById('selectedRegion').value;
        let regions = fetch('https://psgc.gitlab.io/api/regions/')
            .then(response => response.json())
            .then(data => {
                for (let i = 0; i < data.length; i++) {
                    let option = document.createElement('option')
                    option.value = data[i].code
                    option.text = data[i].name
                    if (data[i].code == selectedRegion) {
                        option.selected = true
                        // regionSelect.disabled = true
                    }
                    regionSelect.add(option)
                }
            })
    </script> --}}

@stop
