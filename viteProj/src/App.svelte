<script>
  import { pollMessage } from "./static/poolMessage";
  import { sendMessage } from "./static/sendMessage";
  import { onMount } from "svelte";
  import { logIn } from "./static/setName";
  import { sendCommand } from "./static/sendCommand";
  import { writable } from "svelte/store";
  import { emoteiconize } from "./static/emoteiconize";

  const { subscribe, set, update } = writable([]);
  let messages = [];
  set([]);
  const scrollToBottom = async (node) => {
    if (node){
      node.scroll({ top: node.scrollHeight, behavior: "smooth" });
    }
    node.querySelectorAll(".message").forEach((el) => {
      emoteiconize(el);
    })
  };
  let messagesElem;
  subscribe((mess) => {
    messages = mess;
    setTimeout(() =>scrollToBottom(messagesElem), 10);
  });
  let message = "";
  let name = "";

  onMount(async () => {
    runPooling();
    name = prompt("what's your name");
    await logIn(name);
  });

  async function runPooling() {
    const newMess = await pollMessage();
    update((old) => [...old, ...newMess]);
    setTimeout(runPooling, 50);
  }

  async function send() {
    if (message.length >= 1 && message[0] == "/") {
      const response = await sendCommand(name, message);
      response.Name = "server";
      if (response.newName){
        name = response.newName;
      }
      update((old) => [...old, response]);
    } else {
      await sendMessage(name, message);
    }
    message = "";
  }
  function handleKeyPress(e) {
    if (e.key == "Enter") send();
  }
</script>

<main>
  <div id="messageWindow" >
    <div class="messages" bind:this={messagesElem}>
    <div class="box">

        {#each messages as mess}
          {#if mess.Name == "server"}
            <div class="serverMessage">
              {mess.Message}
            </div>
          {:else}
            <div class="message">
              <div class="time">{mess.SentDate}</div>
              <div class="user" style="color: {mess.Attributes.UserColor};">
                {mess.Name}
              </div>
              <div class="messageValue">{mess.Message}</div>
            </div>
          {/if}
        {/each}
      </div>
    </div>
  </div>
  <div class="input">
    <input type="text" bind:value={message} on:keydown={handleKeyPress} />
    <button on:click={send}>Send</button>
  </div>
</main>

<style>
</style>
