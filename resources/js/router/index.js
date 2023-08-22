import { createWebHistory, createRouter } from 'vue-router'

import Employees from '../components/Employees/Employee'
import EmployeeForm from '../components/Employees/EmployeeForm'

export const routes = [
  {
    name: 'employees',
    path: '/',
    component: Employees,
  },
  {
    name: 'addemployee',
    path: '/employees/add',
    component: EmployeeForm,
  },
  {
    name: 'editemployee',
    path: '/employees/edit/:id',
    component: EmployeeForm,
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
})

export default router
