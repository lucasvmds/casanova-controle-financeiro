<script lang="ts">
    import { page } from "@inertiajs/inertia-svelte";
    import { scale } from "svelte/transition";
    import { flip } from "svelte/animate";
    import { FlashMessagesStore } from "../../ts/stores/flash_messages";
    import { FlashMessage } from "../../ts/types";

    let messages: FlashMessage[] = [];
    let flashMessages: FlashMessage[];
    let storeMessages: FlashMessage[];

    $: flashMessages = $page.props['flash_messages'] ?? [];
    $: storeMessages = $FlashMessagesStore;
    $: {
        if (flashMessages.length > 0) {
            messages = messages.concat(flashMessages);
            flashMessages = [];
        }
        if (storeMessages.length > 0) {
            messages = messages.concat(storeMessages);
            storeMessages = [];
            FlashMessagesStore.set([]);
        }
    }

    function removeMessage(id: string): void
    {
        messages = messages.filter(message => message.id !== id);
    }
</script>

<div id="flash-messages-container">
    {#each messages as message (message.id)}
        <!-- svelte-ignore a11y-click-events-have-key-events -->
        <p class={message.level} on:click={() => removeMessage(message.id)} in:scale={{duration: 200}} animate:flip={{duration: 200}}>
            {message.content}
        </p>
    {/each}
</div>