<x-admin::layouts>
    <x-slot:title>
        @lang('blog::app.admin.blogs.edit')
    </x-slot>

    <x-admin::form
        :action="route('admin.blogs.update', $blog->id)"
        method="PUT"
        enctype="multipart/form-data"
    >
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold text-gray-800">
                @lang('blog::app.admin.blogs.edit')
            </p>

            <div class="flex items-center gap-x-2.5">
                <a
                    href="{{ route('admin.blogs.index') }}"
                    class="transparent-button hover:bg-gray-200"
                >
                    Back
                </a>

                <button
                    type="submit"
                    class="primary-button"
                >
                    Update Article
                </button>
            </div>
        </div>

        <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
            <!-- Left Column: Content Details -->
            <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
                <div class="box-shadow rounded bg-white p-4">
                    <p class="mb-4 text-base font-semibold text-gray-800">
                        Article Content
                    </p>

                    <!-- Title -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            Article Title
                        </x-admin::form.control-group.label>

                        <v-field
                            type="text"
                            name="name"
                            rules="required"
                            value="{{ old('name') ?? $blog->name }}"
                            label="Article Title"
                            v-slot="{ field, errors }"
                        >
                            <input
                                type="text"
                                id="name"
                                :class="[errors.length ? 'border border-red-600 hover:border-red-600' : '']"
                                class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400"
                                name="name"
                                v-bind="field"
                                placeholder="e.g. The Science Behind Bamboo Socks"
                                v-slugify-target:url_key="setValues"
                            />
                        </v-field>

                        <x-admin::form.control-group.error control-name="name" />
                    </x-admin::form.control-group>

                    <!-- URL Key -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            URL Key (Slug)
                        </x-admin::form.control-group.label>

                        <v-field
                            type="text"
                            name="url_key"
                            rules="required"
                            value="{{ old('url_key') ?? $blog->url_key }}"
                            label="URL Key"
                            v-slot="{ field, errors }"
                        >
                            <input
                                type="text"
                                id="url_key"
                                :class="[errors.length ? 'border border-red-600 hover:border-red-600' : '']"
                                class="flex min-h-[39px] w-full rounded-md border px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400"
                                name="url_key"
                                v-bind="field"
                                placeholder="science-behind-bamboo-socks"
                                v-slugify-target:url_key
                            />
                        </v-field>

                        <x-admin::form.control-group.error control-name="url_key" />
                    </x-admin::form.control-group>

                    <!-- Category -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            Category
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="category"
                            value="{{ old('category') ?? $blog->category }}"
                            placeholder="e.g. Bamboo Science, Diabetic Care, Foot Health, Sock Care"
                        />

                        <x-admin::form.control-group.error control-name="category" />
                    </x-admin::form.control-group>

                    <!-- Short Description / Excerpt -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            Short Description (Excerpt)
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            name="short_description"
                            rows="3"
                            value="{{ old('short_description') ?? $blog->short_description }}"
                            placeholder="Brief 1-2 sentence teaser for cards and meta snippets..."
                        />

                        <x-admin::form.control-group.error control-name="short_description" />
                    </x-admin::form.control-group>

                    <!-- Full Content -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            Article Body (HTML/Markdown Supported)
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            name="content"
                            rows="14"
                            value="{{ old('content') ?? $blog->content }}"
                            placeholder="Write your article here..."
                        />

                        <x-admin::form.control-group.error control-name="content" />
                    </x-admin::form.control-group>
                </div>

                <!-- SEO Section -->
                <div class="box-shadow rounded bg-white p-4">
                    <p class="mb-4 text-base font-semibold text-gray-800">
                        Search Engine Optimization
                    </p>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            Meta Title
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="meta_title"
                            value="{{ old('meta_title') ?? $blog->meta_title }}"
                            placeholder="SEO Page Title"
                        />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            Meta Description
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            name="meta_description"
                            rows="3"
                            value="{{ old('meta_description') ?? $blog->meta_description }}"
                            placeholder="SEO Description"
                        />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            Meta Keywords
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="meta_keywords"
                            value="{{ old('meta_keywords') ?? $blog->meta_keywords }}"
                            placeholder="bamboo socks, diabetic socks, foot care"
                        />
                    </x-admin::form.control-group>
                </div>
            </div>

            <!-- Right Column: Settings, Author & Image -->
            <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">
                <div class="box-shadow rounded bg-white p-4">
                    <p class="mb-4 text-base font-semibold text-gray-800">
                        Publication Settings
                    </p>

                    <!-- Status -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            Status
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="switch"
                            name="status"
                            value="1"
                            :checked="old('status') ?? $blog->status"
                        />
                    </x-admin::form.control-group>

                    <!-- Author Name -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            Author Name
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="author_name"
                            value="{{ old('author_name') ?? $blog->author_name }}"
                            placeholder="e.g. Dr. Ananya Sharma"
                        />
                    </x-admin::form.control-group>

                    <!-- Author Title / Role -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            Author Role / Specialty
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="author_title"
                            value="{{ old('author_title') ?? $blog->author_title }}"
                            placeholder="e.g. Podiatry & Foot Wellness Consultant"
                        />
                    </x-admin::form.control-group>

                    <!-- Reading Time -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            Read Time (Minutes)
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="read_time"
                            value="{{ old('read_time') ?? $blog->read_time }}"
                            placeholder="e.g. 5"
                        />
                    </x-admin::form.control-group>

                    <!-- Featured Image -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            Featured Image
                        </x-admin::form.control-group.label>

                        @if ($blog->featured_image)
                            <div class="mb-2">
                                @php
                                    $imgUrl = filter_var($blog->featured_image, FILTER_VALIDATE_URL)
                                        ? $blog->featured_image
                                        : (file_exists(public_path($blog->featured_image))
                                            ? asset($blog->featured_image)
                                            : Storage::url($blog->featured_image));
                                @endphp
                                <img
                                    src="{{ $imgUrl }}"
                                    class="w-full h-36 object-cover rounded-md border border-slate-200"
                                    alt="Current Featured Image"
                                />
                            </div>
                        @endif

                        <input
                            type="file"
                            name="featured_image"
                            accept="image/*"
                            class="flex w-full rounded-md border border-slate-200 px-3 py-2 text-sm text-gray-600 transition-all hover:border-gray-400"
                        />
                        <p class="mt-1 text-xs text-slate-400">Upload a new image to replace current one</p>
                    </x-admin::form.control-group>
                </div>

                <!-- Related Products -->
                @if (isset($products) && $products->isNotEmpty())
                    <div class="box-shadow rounded bg-white p-4">
                        <p class="mb-4 text-base font-semibold text-gray-800">
                            Linked Products (Cross-Sell)
                        </p>

                        @php
                            $selectedProductIds = $blog->products->pluck('id')->toArray();
                        @endphp

                        <div class="flex flex-col gap-2 max-h-60 overflow-y-auto">
                            @foreach ($products as $prod)
                                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer hover:text-[#2ca7a3]">
                                    <input
                                        type="checkbox"
                                        name="product_ids[]"
                                        value="{{ $prod->id }}"
                                        {{ in_array($prod->id, $selectedProductIds) ? 'checked' : '' }}
                                        class="rounded border-slate-300 text-[#2ca7a3] focus:ring-[#2ca7a3]"
                                    />
                                    <span>{{ $prod->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-admin::form>
</x-admin::layouts>
