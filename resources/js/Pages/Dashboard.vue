<template>
	<AppLayout class="" title="Dashboard">
		<div class="py-12 dark:bg-slate-800">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div
					class="
						overflow-hidden
						shadow-xl
						p-2
						sm:p-4
						lg:p-8
						grid
						gap-6
					"
				>
					<EmployerCard
						v-for="(emp, index) in $attrs.employers"
						:key="index"
						:emp="emp"
					/>

					<!-- <pre>

                    {{ $attrs.user }}
                    </pre> -->
				</div>
			</div>
		</div>
	</AppLayout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import EmployerCard from "./Components/EmployerCard.vue";

export default {
	components: {
		AppLayout,
		EmployerCard,
	},
	data() {
		return {};
	},
	methods: {},
};
</script>
