@props(['text' => ''])

<!--
    Small info-icon + hover tooltip used next to the attribute-configuration
    flag labels (Use In Layered, Is Configurable, Value Per Locale, Value
    Per Channel, etc.). Reuses the `icon-information` + `peer` /
    `peer-hover:block` pattern already used on the product inventory view,
    so styling stays consistent.
-->
<span class="relative inline-flex items-center">
    <span class="peer inline-flex cursor-help text-gray-400 transition-colors hover:text-gray-600">
        <i class="fa-solid fa-circle-info text-sm"></i>
    </span>

    <!--
        Tooltip sits ABOVE the icon (`bottom-full` + margin) and is anchored
        to the icon's RIGHT edge (`ltr:right-0` / `rtl:left-0`) so it extends
        toward the centre of the form rather than off the right side of the
        configuration panel. `z-50` keeps it above the accordion chrome.
    -->
    <div
        class="pointer-events-none absolute bottom-full z-50 mb-2 hidden w-64 rounded-lg bg-gray-900 p-2.5 text-xs leading-snug text-white shadow-lg peer-hover:block ltr:right-0 rtl:left-0"
        role="tooltip"
    >
        {{ $text }}
    </div>
</span>
