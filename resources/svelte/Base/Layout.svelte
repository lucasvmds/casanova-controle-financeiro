<script lang="ts">
    import FlashMessages from "./FlashMessages.svelte";
    import Header from "./Header.svelte";
</script>

<Header />
<slot />
<FlashMessages />