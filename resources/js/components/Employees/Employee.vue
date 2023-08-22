<template>

    <div>
        <div v-if="strError" class="error-message">{{ strError }}</div>
    
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between pb-2 mb-2">
                    <h5 class="card-title">All Employees Data</h5>
                    <div>
                        <button class="btn btn-success" type="button" @click="this.$router.push('/employees/add')">New Employee</button>
                    </div>
                </div>
                
                <table class="table table-hover table-sm">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th width="50" class="text-center">#</th>
                            <th>Name</th>
                            <th>Job Title</th>
                            <th>Salary</th>
                            <th class="text-center" width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="employees.length != 0">
                        <tr v-for="(employee, index) in employees" :key="employee.id">
                            <td class="text-center">{{index+1}}.</td>
                            <td>{{employee.name}}</td>
                            <td>{{employee.job_title}}</td>
                            <td>{{employee.salary}}</td>
                            <td class="text-center">
                                <router-link :to="{name:'editemployee', params: {id:employee.id}}" class="btn btn-warning">Edit</router-link>
                                <button class="btn btn-danger" @click="deleteEmployee(employee.id)">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="4" class="text-center">No data found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
    data() {
        return {
            employees: [],
            strSuccess: '',
            strError: ''
        };
    },
    async created() {
        try {
            const response = await this.$axios.get('/api/employees');
            this.employees = response.data;
        } catch (error) {
            this.strError = 'Failed to fetch employee data';
        }
    },
    methods: {
        async deleteEmployee(id) {
            if (confirm("Do you really want to delete this data?")) {
                try {
                    const response = await this.$axios.delete(`/api/employees/delete/${id}`);
                    const index = this.employees.findIndex(item => item.id === id);
                    this.employees.splice(index, 1);
                    this.strError = '';
                    this.strSuccess = response.data.success;
                } catch (error) {
                    this.strError = 'Failed to delete employee';
                }
            }
        }
    }
};

</script>

<style scoped>
    .error-message {
        color: red;
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>