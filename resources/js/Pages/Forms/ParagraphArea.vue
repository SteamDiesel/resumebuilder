<template>
	<div>
		<label
			:for="name"
			class="block text-sm font-medium text-gray-700 dark:text-gray-300"
			>{{ label }}</label
		>
		<div class="mt-1">
            <div class="block
					w-full
                    border
                    pt-2
                    px-3
                    pb-3
					rounded-md
					border-gray-300
					shadow-sm
					focus:border-indigo-500 focus:ring-indigo-500
					sm:text-sm
					dark:text-gray-300 dark:bg-gray-800">
                <slot></slot>
            </div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		label: String,
		name: String,
		help: String,
		rows: Number,
		error: String,
		value: String,
		placeholder: String,
	},
};
</script>

<style>
</style>
