<template>
  <div id="app">
    <nav class="bg-white border-gray-200 px-2 sm:px-4 py-4 rounded" style="background: #00102c">
      <div class="container flex flex-wrap items-center justify-between mx-auto">
        <router-link class="flex items-center" :to="{ name: 'dashboard' }">
          <h3 class="text-white text-3xl">Kanban board</h3>
        </router-link>

        <div v-if="isAuthenticated" class="bottom-0 inline-flex items-center justify-around w-full md:flex md:w-auto md:order-1">
            <ul class="flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium">
                <li>
                    <!-- <router-link class="block py-2 pl-3 pr-4 mr-4 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-300 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700" to="/dasboard"> -->
                    <router-link class="block py-2 pl-3 pr-4 text-gray-500 border-b border-gray-100 hover:bg-gray-50" active-class="bg-gray-100" to="/dashboard">
                        Dashboard
                    </router-link>
                </li>
                <li>
                    <router-link class="block py-2 pl-3 pr-4 text-gray-500 border-b border-gray-100 hover:bg-gray-50" active-class="bg-gray-100" to="/random">404 Ejemplo</router-link>
                </li>
            </ul>
      </div>


        <div class="flex items-center md:order-2">
           <div class="flex flex-col">
              <template v-if="isAuthenticated">
                <span class="text-sm text-white ">Hola, {{ userAuth.name }}</span>
                <button @click="logout" class="text-white text-xs hover:text-[#2DA8E0]">Cerrar sesión</button>
              </template>
              <template v-else>
                <router-link class="text-white text-base hover:text-[#2DA8E0]" :to="{ name: 'login' }">
                  Login
                </router-link>
              </template>
           </div>
        </div>
      </div>

    </nav>

    <!-- <suspense fallback="Loading..."> -->
    <div class="container px-4 py-8 mx-auto">
        <router-view></router-view>
    </div>
    <!-- </suspense> -->

  </div>

</template>

<script>
export default {
    name: "App",
    computed: {
        isAuthenticated() {
            return this.$store.state.auth.isAuthenticated;
        },
        userAuth() {
            return this.$store.state.auth.user;
        }
	},
	methods: {
        async logout() {
            await this.$store.dispatch('logout');
            this.$router.replace({ name: 'login' });
        }
    }
}
</script>
