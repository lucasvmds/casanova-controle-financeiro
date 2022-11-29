import { FlashMessagesStore } from "./stores/flash_messages";
import { FlashMessage, FlashMessageLevel } from "./types";
import { get } from "svelte/store";

export class FlashMessages
{
    private static appendMessage(level: FlashMessageLevel, content: string): void
    {
        const MESSAGES = get(FlashMessagesStore);
        MESSAGES.push({
            id: Math.random().toString(),
            content,
            level,
        });
        FlashMessagesStore.set(MESSAGES);
    }

    public static error(content: string): FlashMessages
    {
        this.appendMessage('error', content);
        return new this;
    }

    public error(content: string): FlashMessages
    {
        FlashMessages.appendMessage('error', content);
        return this;
    }

    public static warning(content: string): FlashMessages
    {
        this.appendMessage('warning', content);
        return new this;
    }

    public warning(content: string): FlashMessages
    {
        FlashMessages.appendMessage('warning', content);
        return this;
    }

    public static success(content: string): FlashMessages
    {
        this.appendMessage('success', content);
        return new this;
    }

    public success(content: string): FlashMessages
    {
        FlashMessages.appendMessage('success', content);
        return this;
    }
}