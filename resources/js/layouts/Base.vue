<template>
  <div class="row">
    <div class="col-md-4 stick-side-bar">
        <a class="navbar-brand">
            <span class="">
                <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="../../img/logo.png" alt="Logo">
            </span>
        </a>
    </div>
    <div class="col-md-8 container-fluid p-0 news-section">
        <div class="header-wrapper">
            <h1> Latest <span>Articles</span> </h1>
            <span class="notice">crawled from https://www.spiegel.de/politik/ </span>
        </div>
        <div class="container">
            <router-view :key="$route.fullPath"></router-view>
        </div>
    </div>
  </div>
</template>

<script>
export default {
};
</script>