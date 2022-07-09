<template>
  <div id="app">

    <h1>hello app vuejs</h1>
      <!-- <suspense fallback="Loading..."> -->
        <!-- <div class="container px-4 py-8 mx-auto"> -->
    <router-view></router-view>
        <!-- </div> -->
      <!-- </suspense> -->

  </div>

</template>

<script>
export default {
    name: "App"
}
</script>

<style>
/* #app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
} */
</style>
