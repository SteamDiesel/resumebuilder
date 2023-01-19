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
                        @deleted="dropEmployer(index)"
					/>
                    <div class="flex">
                        <button v-if="!employer_loading" @click="createEmployer" class="btn-primary">
                            Add Employer
                        </button>
                        <div v-else class="btn-primary cursor-wait">
                            Add Employer
                        </div>
                    </div>


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
import { toast } from "vue3-toastify";

export default {
	components: {
		AppLayout,
		EmployerCard,
	},
	data() {
        return {
            employer_loading: false
        };
	},
    methods: {
        dropEmployer(ind) {
			this.$attrs.employers.splice(ind, 1);
		},
        createEmployer() {
            this.employer_loading = true;
			axios
				.post("/create_employer", {})
				.then((r) => {
                    console.log(r.data.employer);
                    this.$attrs.employers.push(r.data.employer)
                    this.employer_loading = false;
                    toast.success("New Employer Created", { autoClose: 1000 });
				})
				.catch((e) => {
                    console.log(e);
                    toast.error(e.message, { autoClose: 3000 });
                    this.employer_loading =  false;
				});
		},
	},
};
</script>
