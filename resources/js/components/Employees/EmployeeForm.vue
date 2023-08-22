<template>

    <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>{{ strSuccess }}</strong>
    </div>

    <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>{{ strError }}</strong>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">{{ $route.params.id ? 'Edit Employee' : 'Add Employee' }}</h5>
                <div>
                    <router-link :to="{name: 'employees'}" class="btn btn-success">Go Back</router-link>
                </div>
            </div>
            <div v-if="employeeStatus">

                <form @submit.prevent="saveData">
                    <div class="form-group mb-2">
                        <label>Name</label><span class="text-danger"> *</span>
                        <input type="text" class="form-control" v-model="name" placeholder="Enter employee's name">
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>

                    <div class="form-group mb-2">
                        <label>Job Title</label><span class="text-danger"> *</span>
                        <input type="text" class="form-control" v-model="job_title" placeholder="Enter job title">
                        <div v-if="errors && errors.job_title" class="text-danger">{{ errors.job_title[0] }}</div>
                    </div>

                    <div class="form-group mb-2">
                        <label>Salary</label><span class="text-danger"> *</span>
                        <input type="text" class="form-control" v-model="salary" placeholder="Enter salary">
                        <div v-if="errors && errors.salary" class="text-danger">{{ errors.salary[0] }}</div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 mb-4"> {{ $route.params.id ? 'Edit Employee' : 'Add Employee' }}</button>

                </form>
            </div>
            
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            job_title: '',
            salary: '',
            strSuccess: '',
            strError: '',
            errors: null,
            employeeStatus: true
        };
    },
    async mounted() {
        if (this.$route.params.id) {
            try{
                const { data } = await this.$axios.get(`/api/employees/edit/${this.$route.params.id}`);
                this.name = data.name;
                this.job_title = data.job_title;
                this.salary = data.salary;
            }
            catch(error) {
                if (error.response.status === 404) {
                    this.strError = error.response.data.error;
                    if(this.strError == "Employee not found") {
                        this.employeeStatus = false;
                    }
                }
            }
        }
    },
    methods: {
        async saveData(e) {
            const apiUrl = this.$route.params.id ? `/api/employees/update/${this.$route.params.id}` : '/api/employees/add';

            const requestData = {
                name: this.name,
                job_title: this.job_title,
                salary: this.salary
            };

            try {
                const response = await this.$axios[this.$route.params.id ? 'put' : 'post'](apiUrl, requestData);
                this.strSuccess = response.data.success;
                if(!(this.$route.params.id)) {
                    this.$router.push('/');
                }
                this.errors = null;
                this.strError = '';
            } catch (error) {
                this.errors = null;
                this.strError = '';
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
                if (error.response.status === 500) {
                    this.strError = error.response.data.error;
                }
                if (error.response.status === 404) {
                    this.strError = error.response.data.error;
                }
            }
        }
    }
};
</script>