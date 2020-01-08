const routes = [
  {
    path: "/panel",
    component: () => import("layouts/AuthLayout.vue"),
    children: [
      {
        path: "",
        name: 'dashboard',
        component: () => import("pages/main/Dashboard.vue"),
        meta: {
          requiresAuth: true
        },
      },
      {
        path: 'productos',
        component: () => import("pages/products/ProductsWrapper"),
        children: [
          {
            path: 'listado',
            name: 'products-list',
            component: () => import("pages/products/ProductsList.vue"),
            meta: {
              requiresAuth: true
            },
          },
        ]
      },
      {
        path: 'servicios',
        component: () => import("pages/services/ServicesWrapper"),
        children: [
          {
            path: 'listado',
            name: 'services-list',
            component: () => import("pages/services/ServicesList.vue"),
            meta: {
              requiresAuth: true
            },
          },
        ]
      },
      {
        path: 'categorias',
        component: () => import("pages/budgets/BudgetsWrapper"),
        children: [
          {
            path: 'listado',
            name: 'product-categories',
            component: () => import("pages/products/ProductCategories.vue"),
            meta: {
              requiresAuth: true
            },
          },
        ]
      },
      {
        path: 'presupuestos',
        component: () => import("pages/budgets/BudgetsWrapper"),
        children: [
          {
            path: 'listado',
            name: 'budgets-list',
            component: () => import("pages/budgets/BudgetsList.vue"),
            meta: {
              requiresAuth: true
            },
          },
        ]
      },
      {
        path: 'clientes',
        component: () => import("pages/clients/ClientsWrapper"),
        children: [
          {
            path: 'listado',
            name: 'clients-list',
            component: () => import("pages/clients/ClientsList.vue"),
            meta: {
              requiresAuth: true
            },
          },
        ]
      },
      {
        path: 'configuracion',
        name: 'settings',
        component: () => import("pages/main/Settings.vue"),
        meta: {
          requiresAuth: true
        },
      },
      {
        path: "mi-cuenta",
        name: "my_account",
        component: () => import("pages/myAccount/MyAccountIndex.vue"),
        meta: {
          requiresAuth: true
        },
      },

    ]
  },
  {
    path: "/",
    component: () => import("layouts/PublicLayout.vue"),
    children: [
      {
        path: "",
        name: "login",
        component: () => import("pages/auth/login.vue"),
        meta: {requiresAuth: false},
      },
      {
        path: "recuperar-contraseña",
        name: "recover-password",
        component: () => import("pages/auth/RecoverPassword.vue"),
        meta: {requiresAuth: false},
      }
    ]
  }
];

// Always leave this as last one
if (process.env.MODE !== "ssr") {
  routes.push({
    path: "*",
    component: () => import("pages/Error404.vue")
  });
}

export default routes;
