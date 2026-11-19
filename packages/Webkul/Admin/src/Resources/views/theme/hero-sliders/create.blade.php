<x-admin::layouts>
    <x-slot:title>
        Create Hero Slider
    </x-slot>

    <!-- Input Form -->
    <x-admin::form
        :action="route('admin.cms.hero_sliders.store')"
        enctype="multipart/form-data"
    >
        <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
            <p class="text-xl text-gray-800 font-bold">
                Create Hero Slider
            </p>

            <div class="flex gap-x-2.5 items-center">
                <!-- Cancel Button -->
                <a
                    href="{{ route('admin.cms.hero_sliders.index') }}"
                    class="transparent-button hover:bg-gray-200"
                >
                    @lang('admin::app.cms.edit.back-btn')
                </a>

                <!-- Save Button -->
                <button 
                    type="submit" 
                    class="primary-button"
                >
                    Save Slider
                </button>
            </div>
        </div>

        <!-- body content -->
        <div class="flex gap-2.5 mt-3.5 max-xl:flex-wrap">
            <!-- Left sub-component -->
            <div class="flex flex-col gap-2.5 flex-1 max-xl:flex-auto">
                <div class="p-4 bg-white rounded box-shadow">
                    <p class="text-base text-gray-800 font-semibold mb-4">
                        General
                    </p>

                    <!-- Slider Name -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            Name
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="name"
                            :value="old('name')"
                            rules="required"
                            label="Name"
                            placeholder="Name"
                        >
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error
                            control-name="name"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <!-- Slider Code -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            Code (Identifier)
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="code"
                            :value="old('code')"
                            rules="required"
                            label="Code"
                            placeholder="homepage-hero"
                        >
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error
                            control-name="code"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>
                    
                    <!-- Placement -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            Placement
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="select"
                            name="placement"
                            :value="old('placement')"
                            rules="required"
                            label="Placement"
                        >
                            <option value="homepage">Homepage</option>
                            <option value="category">Category</option>
                            <option value="custom">Custom</option>
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error
                            control-name="placement"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                </div>
            </div>

            <!-- Right sub-component -->
            <div class="flex flex-col gap-2.5 w-[360px] max-w-full max-sm:w-full">
                <!-- Settings Panel -->
                <div class="p-4 bg-white rounded box-shadow">
                    <p class="text-base text-gray-800 font-semibold mb-4">
                        Settings
                    </p>

                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label>
                            Status
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="switch"
                            name="status"
                            class="cursor-pointer"
                            value="1"
                            label="Status"
                            :checked="true"
                        >
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error
                            control-name="status"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <!-- Autoplay Enabled -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label>
                            Autoplay
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="switch"
                            name="settings[autoplay]"
                            class="cursor-pointer"
                            value="1"
                            label="Autoplay"
                            :checked="true"
                        >
                        </x-admin::form.control-group.control>
                    </x-admin::form.control-group>

                    <!-- Autoplay Speed / Duration (ms) -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            Autoplay Speed (ms)
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="settings[duration]"
                            value="6000"
                            rules="required|numeric|min_value:1000"
                            label="Autoplay Speed (ms)"
                            placeholder="6000"
                        >
                        </x-admin::form.control-group.control>

                        <p class="text-xs text-gray-500 mt-1">
                            Duration per slide in milliseconds (e.g. 5000 = 5s, 6000 = 6s, 8000 = 8s).
                        </p>
                    </x-admin::form.control-group>
                </div>
            </div>
        </div>
    </x-admin::form>
</x-admin::layouts>
