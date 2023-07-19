@extends('layouts.admin')


@section('title', 'Eco Bohol - Journals')


@section('content')

    <div class="common-background flex-1 pt-5 px-5 pb-40 overflow-y-auto">
        <div class="flex justify-between md:mb-5 border-b-2 pb-5 bg-white">
            <h1 class="text-lg md:text-2x1">{{ ucfirst($action) }} Journals</h1>
            <a href="/admin/manage-journals"
                class="h-8 min-[320px]:w-12 sm:w-24 md:w-24 lg:w-24 bg-gray-400 text-white rounded-md hover:bg-gray-600 justify-center items-center flex">Back</a>
        </div>
        <form action="{{ '/admin/manage-journals/' . ($action == 'update' ? $journals->resjournal_id : 'add') }}"
            method="POST" enctype="multipart/form-data">
            @if ($action == 'update')
                @method('patch')
            @else
                @method('put')
            @endif
            @csrf
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Journal Title</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="title">Title</label>
                        <input class="common-input w-96" type="text" name="title"
                            value='{{ old('title', $journals ? $journals->title : null) }}' required>
                        @error('title')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Journal Details</h6>
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3">
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="author">Author</label>
                            <input class="common-input w-80" type="text" name="author"
                                value='{{ old('author', $journals ? $journals->author : null) }}' required>
                            @error('author')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="publisher">Publisher</label>
                            <input class="common-input w-80" type="text" name="publisher"
                                value='{{ old('publisher', $journals ? $journals->publisher : null) }}' required>
                            @error('publisher')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:ml-10 flex flex-col mb-2 md:mb-0">
                            <label for="date_published">Date Published </label>
                            <input class="common-input w-80" type="date" name="date_published"
                                value='{{ old('date_published', $journals ? $journals->date_published : null) }}' required>
                            @error('date_published')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Journal File</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="journal_file">Attachment</label>
                        <input type="file" class="common-input md:w-64" name="journal_file[]" multiple id="journal_file">
                        @error('journal_file')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($journals)
                        <div class="md:ml-10 mt-5 flex">
                            <span class="flex-initial p-3 bg-gray-100 rounded-xl  hover:bg-green-100">
                                <span class="">Attachments: </span>
                                <span class="font-bold">
                                    @foreach ($journals->journal_file as $attachment)
                                        @if ($attachment->attachmentFor == 'journal_file')
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
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Journal Cover Photo</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="journal_img">Image</label>
                        <input type="file" class="common-input md:w-64" name="journal_img[]" id="image" multiple
                            accept="image/*">
                        @error('journal_img')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="w-full md:w-1/6 mb-2 font-bold">
                        <h6>Species</h6>
                    </div>
                    <div class="md:ml-10 flex flex-col">
                        <label for="species">Species</label>
                        <select class="common-input w-80" type="text" name="species[]" id="species" multiple
                            multiple-search="true" multiselect-select-all="true">
                            @foreach ($speciesrecord as $mangrove)
                                <option value="{{ $mangrove->species_id }}"
                                    {{ in_array($mangrove->species_id, $selectedSpecies) ? 'selected' : '' }}>
                                    {{ $mangrove->common_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('species')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex py-10 px-5 space-x-2">
                <button type="submit" class="primary-btn w-24">Submit</button>
                <a href='/admin/manage-journals'
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
@stop
