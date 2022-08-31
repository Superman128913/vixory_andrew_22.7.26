Nova.booting((Vue, router, store) => {
  Vue.component('icon-edit', require('./components/icons/IconEdit'))
  Vue.component('icon-healthy', require('./components/icons/IconHealthy'))
  Vue.component('icon-unhealthy', require('./components/icons/IconUnhealthy'))

  router.addRoutes([
    {
      name: 'user-approval',
      path: '/user-approval',
      component: require('./components/Tool'),
    },
  ])
})