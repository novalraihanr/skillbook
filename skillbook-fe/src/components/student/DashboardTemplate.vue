<script setup>

</script>

<template>
  <div class="flex flex-col pl-70 mt-10 max-w-screen">
    <div>
      <h1 class="text-4xl font-bold font-outfit">
        <slot name="title"></slot>
      </h1>
    </div>
    <slot name="content"></slot>
  </div>
</template>
