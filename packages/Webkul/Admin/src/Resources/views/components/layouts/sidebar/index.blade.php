<div class="fixed top-14 z-[1000] h-full w-[270px] bg-white border-r border-slate-200 pt-4 shadow-sm transition-all duration-300 group-[.sidebar-collapsed]/container:w-[70px] max-lg:hidden">
    <div class="journal-scroll h-[calc(100vh-100px)] overflow-auto pb-20 group-[.sidebar-collapsed]/container:overflow-visible">
        <nav class="grid w-full gap-1.5 px-3">
            <!-- Navigation Menu -->
            @foreach (menu()->getItems('admin') as $menuItem)
                <div
                    class="group/item {{ $menuItem->isActive() ? 'active' : 'inactive' }}"
                    onmouseenter="adjustSubMenuPosition(event)"
                >
                    <a
                        href="{{ $menuItem->getUrl() }}"
                        class="flex gap-3 p-2.5 items-center cursor-pointer rounded-[12px] transition-all {{ $menuItem->isActive() == 'active' ? 'bg-[#133b63]/10 text-[#133b63] border border-[#133b63]/20 shadow-sm font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-transparent font-medium' }} peer"
                    >
                        <span class="{{ $menuItem->getIcon() }} text-xl {{ $menuItem->isActive() ? 'text-[#133b63]' : 'text-slate-500'}}"></span>

                        <p class="whitespace-nowrap text-sm group-[.sidebar-collapsed]/container:hidden flex-1 {{ $menuItem->isActive() ? 'text-[#133b63] font-semibold' : 'text-slate-700'}}">
                            {{ $menuItem->getName() }}
                        </p>
                        @if ($menuItem->haveChildren())
                            <span class="icon-sort-right text-lg group-[.sidebar-collapsed]/container:hidden {{ $menuItem->isActive() ? 'text-[#133b63]' : 'text-slate-500'}}"></span>
                        @endif
                    </a>

                    @if ($menuItem->haveChildren())
                        <div class="{{ $menuItem->isActive() ? '!grid bg-slate-50/90 border border-slate-200 mt-1' : '' }} hidden min-w-[180px] ltr:pl-9 rtl:pr-9 py-2 rounded-[12px] z-[100] group-[.sidebar-collapsed]/container:!hidden group-[.sidebar-collapsed]/container:fixed group-[.sidebar-collapsed]/container:ltr:!left-[70px] group-[.sidebar-collapsed]/container:rtl:!right-[70px] group-[.sidebar-collapsed]/container:p-2 group-[.sidebar-collapsed]/container:bg-white group-[.sidebar-collapsed]/container:border group-[.sidebar-collapsed]/container:border-slate-200 group-[.sidebar-collapsed]/container:rounded-[14px] group-[.sidebar-collapsed]/container:shadow-lg group-[.sidebar-collapsed]/container:group-hover/item:!grid group-[.inactive]/item:hidden group-[.inactive]/item:fixed group-[.inactive]/item:ltr:left-[270px] group-[.inactive]/item:rtl:right-[270px] group-[.inactive]/item:p-2 group-[.inactive]/item:bg-white group-[.inactive]/item:border group-[.inactive]/item:border-slate-200 group-[.inactive]/item:rounded-[14px] group-[.inactive]/item:shadow-lg group-[.inactive]/item:group-hover/item:!grid">
                            <!-- Invisible Hover Bridge to prevent submenu from closing when moving cursor -->
                            <div
                                class="absolute pointer-events-auto bg-transparent group-[.active]/item:hidden"
                                style="{{ core()->getCurrentLocale()->direction === 'ltr' ? 'left: -24px;' : 'right: -24px;' }} width: 24px; top: -12px; bottom: -12px;"
                            ></div>

                            @foreach ($menuItem->getChildren() as $subMenuItem)
                                <a
                                    href="{{ $subMenuItem->getUrl() }}"
                                    class="{{ $subMenuItem->haveChildren() ? 'font-medium' : '' }} text-xs sm:text-sm {{ $subMenuItem->isActive() ? 'text-[#133b63] font-semibold bg-[#133b63]/10 rounded-lg px-2.5' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 px-2.5 rounded-lg' }} whitespace-nowrap py-1.5 transition-all group-[.sidebar-collapsed]/container:px-4 group-[.sidebar-collapsed]/container:py-2 group-[.inactive]/item:px-4 group-[.inactive]/item:py-2"
                                >
                                    {{ $subMenuItem->getName() }}
                                </a>

                                @if ($subMenuItem->haveChildren())
                                    <div class="grid ltr:pl-3 rtl:pr-3 group-[.inactive]/item:hidden group-[.sidebar-collapsed]/container:hidden">
                                        @foreach ($subMenuItem->getChildren() as $subSubMenuItem)
                                            <a
                                                href="{{ $subSubMenuItem->getUrl() }}"
                                                class="text-xs {{ $subSubMenuItem->isActive() ? 'text-[#133b63] font-semibold' : 'text-slate-500 hover:text-slate-900' }} whitespace-nowrap py-1 px-2 transition-all"
                                            >
                                                {{ $subSubMenuItem->getName() }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </nav>
    </div>

    <!-- Collapse menu -->
    <v-sidebar-collapse></v-sidebar-collapse>
</div>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-sidebar-collapse-template"
    >
        <div
            class="fixed bottom-0 w-full max-w-[270px] cursor-pointer border-t border-slate-200 bg-white px-4 transition-all duration-300 hover:bg-slate-50"
            :class="{'max-w-[70px]': isCollapsed}"
            @click="toggle"
        >
            <div class="flex items-center gap-2.5 p-2 text-slate-600 hover:text-slate-900 transition-colors">
                <span
                    class="icon-collapse text-xl transition-all"
                    :class="[isCollapsed ? 'ltr:rotate-[180deg] rtl:rotate-[0]' : 'ltr:rotate-[0] rtl:rotate-[180deg]']"
                ></span>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-sidebar-collapse', {
            template: '#v-sidebar-collapse-template',

            data() {
                return {
                    isCollapsed: {{ request()->cookie('sidebar_collapsed') ?? 0 }},
                }
            },

            methods: {
                toggle() {
                    this.isCollapsed = parseInt(this.isCollapsedCookie()) ? 0 : 1;

                    var expiryDate = new Date();

                    expiryDate.setMonth(expiryDate.getMonth() + 1);

                    document.cookie = 'sidebar_collapsed=' + this.isCollapsed + '; path=/; expires=' + expiryDate.toGMTString();

                    this.$root.$refs.appLayout.classList.toggle('sidebar-collapsed');
                },

                isCollapsedCookie() {
                    const cookies = document.cookie.split(';');

                    for (const cookie of cookies) {
                        const [name, value] = cookie.trim().split('=');

                        if (name === 'sidebar_collapsed') {
                            return value;
                        }
                    }

                    return 0;
                },
            },
        });
    </script>

    <script>
        const adjustSubMenuPosition = (event) => {
            let menuContainer = event.currentTarget;

            let subMenuContainer = menuContainer.lastElementChild;

            if (subMenuContainer) {
                const menuTopOffset = menuContainer.getBoundingClientRect().top;

                const subMenuHeight = subMenuContainer.offsetHeight;

                const availableHeight = window.innerHeight - menuTopOffset;

                let subMenuTopOffset = menuTopOffset;

                if (subMenuHeight > availableHeight) {
                    subMenuTopOffset = menuTopOffset - (subMenuHeight - availableHeight);
                }

                subMenuContainer.style.top = `${subMenuTopOffset}px`;
            }
        };
    </script>
@endpushOnce
