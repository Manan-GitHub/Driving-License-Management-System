<template>
  
</template>

<script>
export default {
    async Created(){
        const res = await this.callApi('get', '/logout')
    }
}
</script>

<style>

</style>