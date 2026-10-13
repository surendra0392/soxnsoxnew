<v-image-search>
    <button
        type="button"
        class="absolute top-3 flex items-center text-xl max-sm:top-2.5 ltr:right-3 ltr:pr-3 max-md:ltr:right-1.5 rtl:left-3 rtl:pl-3 max-md:rtl:left-1.5 text-soxnsox-muted hover:text-soxnsox-teal transition-colors"
        aria-label="@lang('shop::app.search.images.index.search')"
    >
        <i class="fa-solid fa-camera text-base"></i>
    </button>
</v-image-search>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-image-search-template"
    >
        <div>
            <label
                class="absolute top-3 flex cursor-pointer items-center text-xl max-sm:top-2.5 ltr:right-3 ltr:pr-3 max-md:ltr:right-1.5 rtl:left-3 rtl:pl-3 max-md:rtl:left-1.5 text-soxnsox-muted hover:text-soxnsox-teal transition-colors"
                aria-label="@lang('shop::app.search.images.index.search')"
                :for="'v-image-search-' + $.uid"
                v-if="! isSearching"
            >
                <i class="fa-solid fa-camera text-base"></i>
            </label>

            <label
                class="absolute top-2.5 flex cursor-pointer items-center text-xl ltr:right-3 ltr:pr-3 max-md:ltr:pr-1 rtl:left-3 rtl:pl-3 max-md:rtl:pl-1"
                v-else
            >
                <!-- Spinner -->
                <i class="fa-solid fa-spinner fa-spin text-base text-black"></i>
            </label>

            <input
                type="file"
                class="hidden"
                accept="image/*"
                ref="imageSearchInput"
                :id="'v-image-search-' + $.uid"
                @change="analyzeImage()"
            />

            <img
                id="uploaded-image-url"
                class="hidden"
                :src="uploadedImageUrl"
                alt="uploaded image url"
                width="20"
                height="20"
            />
        </div>
    </script>

    <script type="module">
        app.component('v-image-search', {
            template: '#v-image-search-template',

            data() {
                return {
                    uploadedImageUrl: '',

                    isSearching: false,
                };
            },

            methods: {
                analyzeImage() {
                    let imageInput = this.$refs.imageSearchInput;

                    if (! imageInput.files || ! imageInput.files[0]) {
                        return;
                    }

                    if (! imageInput.files[0].type.includes('image/')) {
                        imageInput.value = '';

                        this.$emitter.emit('add-flash', { type: 'error', message: '@lang('shop::app.search.images.index.only-images-allowed')'});

                        return;
                    }

                    if (imageInput.files[0].size > 2000000) {
                        imageInput.value = '';

                        this.$emitter.emit('add-flash', { type: 'error', message: '@lang('shop::app.search.images.index.size-limit-error')'});

                        return;
                    }

                    this.isSearching = true;

                    let formData = new FormData();

                    formData.append('image', imageInput.files[0]);

                    this.$axios.post('{{ route('shop.search.upload') }}', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            },
                        })
                        .then(response => {
                            let data = response.data;

                            this.uploadedImageUrl = data.image_url;

                            localStorage.searchedImageUrl = data.image_url;

                            if (data.engine === 'ai' && data.keywords) {
                                this.handleAiResult(data.keywords);
                            } else {
                                this.handleTensorflowResult();
                            }
                        })
                        .catch(() => {
                            this.$emitter.emit('add-flash', { type: 'error', message: "@lang('shop::app.search.images.index.something-went-wrong')"});

                            this.isSearching = false;
                        });
                },

                handleAiResult(keywords) {
                    let terms = keywords
                        .split(',')
                        .map(t => t.trim())
                        .filter(t => t.length > 0);

                    if (! terms.length) {
                        this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('shop::app.search.images.index.something-went-wrong')"});

                        this.isSearching = false;

                        return;
                    }

                    localStorage.searchedTerms = terms.join('_');

                    window.location.href = `{{ route('shop.search.index') }}?query=${encodeURIComponent(terms[0])}&image-search=1`;
                },

                handleTensorflowResult() {
                    this.$shop.loadDynamicScript(
                        'https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js', () => {
                            this.$shop.loadDynamicScript(
                                'https://cdn.jsdelivr.net/npm/tensorflow-models-mobilenet-patch@2.1.1/dist/mobilenet.min.js', () => {
                                    this.classifyWithTensorflow();
                                }
                            );
                        }
                    );
                },

                async classifyWithTensorflow() {
                    try {
                        let analysedResult = [];

                        let net = await mobilenet.load();

                        const result = await net.classify(document.getElementById('uploaded-image-url'));

                        result.forEach(function(value) {
                            let queryString = value.className.split(',');

                            if (queryString.length > 1) {
                                analysedResult = analysedResult.concat(queryString);
                            } else {
                                analysedResult.push(queryString[0]);
                            }
                        });

                        localStorage.searchedTerms = analysedResult.join('_');

                        let query = analysedResult[0].split(' ').join('+');

                        window.location.href = `{{ route('shop.search.index') }}?query=${query}&image-search=1`;
                    } catch (error) {
                        this.$emitter.emit('add-flash', { type: 'error', message: "@lang('shop::app.search.images.index.something-went-wrong')"});

                        this.isSearching = false;
                    }
                },
            },
        });
    </script>
@endPushOnce
