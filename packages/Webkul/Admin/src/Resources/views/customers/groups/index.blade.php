<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.customers.groups.index.title')
    </x-slot>

    {!! view_render_event('bagisto.admin.customers.groups.create.before') !!}

    <v-create-group />

    {!! view_render_event('bagisto.admin.customers.groups.create.after') !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-create-group-template"
        >
            <div>
                <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                            @lang('admin::app.customers.groups.index.title')
                        </h1>
                        <p class="mt-0.5 text-xs text-slate-500">
                            Segment customers into tiered wholesale, VIP, and general marketing groups.
                        </p>
                    </div>

                    <div class="flex items-center gap-2.5">
                        <!-- Create a new Group -->
                        @if (bouncer()->hasPermission('customers.groups.create'))
                            <button
                                type="button"
                                class="primary-button"
                                @click="selectedGroups=0; $refs.groupUpdateOrCreateModal.open()"
                            >
                                <i class="fa-solid fa-plus text-xs mr-1"></i>
                                @lang('admin::app.customers.groups.index.create.create-btn')
                            </button>
                        @endif
                    </div>
                </div>

                {!! view_render_event('bagisto.admin.customers.groups.list.before') !!}

                <x-admin::datagrid src="{{ route('admin.customers.groups.index') }}" ref="datagrid">
                    <template #body="{
                        isLoading,
                        available,
                        applied,
                        selectAll,
                        sort,
                        performAction
                    }">
                        <template v-if="isLoading">
                            <x-admin::shimmer.datagrid.table.body />
                        </template>

                        <template v-else>
                            <div
                                v-for="record in available.records"
                                class="row grid items-center gap-2.5 border-b border-slate-100 px-4 py-3.5 text-slate-700 transition-all hover:bg-slate-50/80 last:border-b-0"
                                :style="`grid-template-columns: repeat(${gridsCount}, minmax(0, 1fr))`"
                            >
                                <!-- ID -->
                                <p class="font-mono text-xs text-slate-400">#@{{ record.id }}</p>

                                <!-- Code -->
                                <p class="font-mono text-xs font-semibold text-slate-700">@{{ record.code }}</p>

                                <!-- Name -->
                                <p class="text-sm font-semibold text-slate-900">@{{ record.name }}</p>

                                <!-- Actions -->
                                <div class="flex justify-end gap-1">
                                    @if (bouncer()->hasPermission('customers.groups.edit'))
                                        <a @click="selectedGroups=1; editModal(record)">
                                            <span
                                                :class="record.actions.find(action => action.index === 'edit')?.icon"
                                                class="cursor-pointer rounded-lg p-1.5 text-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-all"
                                                :title="record.actions.find(action => action.title === '@lang('admin::app.customers.groups.index.datagrid.edit')')?.title"
                                            >
                                            </span>
                                        </a>
                                    @endif

                                    @if (bouncer()->hasPermission('customers.groups.delete'))
                                        <a @click="performAction(record.actions.find(action => action.index === 'delete'))">
                                            <span
                                                :class="record.actions.find(action => action.index === 'delete')?.icon"
                                                class="cursor-pointer rounded-lg p-1.5 text-xl text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition-all"
                                                :title="record.actions.find(action => action.title === '@lang('admin::app.customers.groups.index.datagrid.delete')')?.title"
                                            >
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </template>
                    </template>
                </x-admin::datagrid>

                {!! view_render_event('bagisto.admin.customers.groups.list.after') !!}

                <!-- Modal Form -->
                <x-admin::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                    ref="modalForm"
                >
                    <form
                        @submit="handleSubmit($event, updateOrCreate)"
                        ref="groupCreateForm"
                    >
                        <!-- Create Group Modal -->
                        <x-admin::modal ref="groupUpdateOrCreateModal">
                            <!-- Modal Header -->
                            <x-slot:header>
                                <p class="text-lg font-bold text-gray-800">
                                    <span v-if="selectedGroups">
                                        @lang('admin::app.customers.groups.index.edit.title')
                                    </span>

                                    <span v-else>
                                        @lang('admin::app.customers.groups.index.create.title')
                                    </span>
                                </p>
                            </x-slot>

                            <!-- Modal Content -->
                            <x-slot:content>
                                <!-- Code -->
                                <x-admin::form.control-group>
                                    <x-admin::form.control-group.label class="required">
                                        @lang('admin::app.customers.groups.index.create.code')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="hidden"
                                        name="id"
                                    />

                                    <x-admin::form.control-group.control
                                        type="text"
                                        id="code"
                                        name="code"
                                        rules="required"
                                        :label="trans('admin::app.customers.groups.index.create.code')"
                                        :placeholder="trans('admin::app.customers.groups.index.create.code')"
                                    />

                                    <x-admin::form.control-group.error control-name="code" />
                                </x-admin::form.control-group>

                                <!-- Last Name -->
                                <x-admin::form.control-group>
                                    <x-admin::form.control-group.label class="required">
                                        @lang('admin::app.customers.groups.index.create.name')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="text"
                                        id="last_name"
                                        name="name"
                                        rules="required"
                                        :label="trans('admin::app.customers.groups.index.create.name')"
                                        :placeholder="trans('admin::app.customers.groups.index.create.name')"
                                    />

                                    <x-admin::form.control-group.error control-name="name" />
                                </x-admin::form.control-group>
                            </x-slot>

                            <!-- Modal Footer -->
                            <x-slot:footer>
                                <!-- Save Button -->
                                <x-admin::button
                                    button-type="submit"
                                    class="primary-button"
                                    :title="trans('admin::app.customers.groups.index.create.save-btn')"
                                    ::loading="isLoading"
                                    ::disabled="isLoading"
                                />
                            </x-slot>
                        </x-admin::modal>
                    </form>
                </x-admin::form>
            </div>
        </script>

        <script type="module">
            app.component('v-create-group', {
                template: '#v-create-group-template',

                data() {
                    return {
                        selectedGroups: 0,

                        isLoading: false,
                    }
                },

                computed: {
                    gridsCount() {
                        let count = this.$refs.datagrid.available.columns.length;

                        if (this.$refs.datagrid.available.actions.length) {
                            ++count;
                        }

                        if (this.$refs.datagrid.available.massActions.length) {
                            ++count;
                        }

                        return count;
                    },
                },

                methods: {
                    updateOrCreate(params, { resetForm, setErrors  }) {
                        this.isLoading = true;

                        let formData = new FormData(this.$refs.groupCreateForm);

                        if (params.id) {
                            formData.append('_method', 'put');
                        }

                        this.$axios.post(params.id ? "{{ route('admin.customers.groups.update') }}" : "{{ route('admin.customers.groups.store') }}", formData)
                            .then((response) => {
                                this.isLoading = false;

                                this.$refs.groupUpdateOrCreateModal.close();

                                this.$refs.datagrid.get();

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                resetForm();
                            })
                            .catch(error => {
                                this.isLoading = false;

                                if (error.response.status == 422) {
                                    setErrors(error.response.data.errors);
                                }
                            });
                    },

                    editModal(value) {
                        this.$refs.groupUpdateOrCreateModal.toggle();

                        this.$refs.modalForm.setValues(value);
                    },
                }
            })
        </script>
    @endPushOnce

</x-admin::layouts>
