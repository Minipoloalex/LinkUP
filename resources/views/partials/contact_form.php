<div id="contactForm" class="flex flex-col justify-center items-center w-full">
    <form id="contactFormElement" class="flex flex-col">

        <!-- Your form fields -->
        <!-- ... -->

        <label for="subject" class="block mb-2"></label>
        <select id="subject" name="subject" class="w-full border-b border-gray-300 rounded-md p-2 mb-4 focus:border-indigo-500" required>
            <option value="" disabled selected>Subject</option>
            <option value="option1">Report a Problem</option>
            <option value="option2">Report Abuse or Harassment</option>
            <option value="option3">Account Security or Access</option>
            <option value="option4">Privacy Concerns</option>
            <option value="option5">Feedback or Suggestions</option>
            <option value="option6">Other</option>
        </select>

        <div class="flex flex-row justify-evenly">
            <label for="name" class="block mb-2"></label>
            <input type="text" id="name" name="name" class="w-full border-b border-gray-300 mr-2 rounded-md p-2 mb-4 focus:border-indigo-500 focus:outline-none" placeholder="Name" required>

            <label for="email" class="block mb-2"></label>
            <input type="email" id="email" name="email" required class="w-full border-b border-gray-300 rounded-md p-2 mb-4 focus:border-indigo-500 focus:outline-none" placeholder="Email">
        </div>

        <label for="message" class="block mb-2"></label>
        <textarea id="message" name="message" class="w-full border-b border-gray-300 rounded-md p-2 mb-4 focus:border-indigo-500 focus:outline-none" style="resize: none; overflow-y: hidden;" placeholder="Message [remember, short & kind please]" required></textarea>

        <div class="flex justify-center">
            <button type="button" onclick="submitForm()" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full mr-1">Send</button>
            <button type="button" onclick="cancelForm()" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-full">Cancel</button>
        </div>
    </form>
</div>
