<script lang="ts" context="module">
    export type Error<T> = {
        [K in keyof T]?: string;
    }
</script>

<script lang="ts">
    export let error: string | undefined;
</script>

{#if error}
    <br />
    <small class="error-component">
        {error}
    </small>
{/if}