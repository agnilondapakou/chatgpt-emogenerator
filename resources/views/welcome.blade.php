<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap');

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }

            section{
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                width: 100%;
                background: #ff6f00;
            }

            .form-box{
                width: 500px;
                height: 500px;
                background: #aa1b1b;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0,0,0,0.2);
                position: relative;
                display: flex;
                justify-content: center;
            }

            h2{
                font-size: 30px;
                font-weight: 500;
                text-align: center;
                margin: 20px 0;
                color: #fff;
            }

            .inputbox{
                position: relative;
                margin: 30px 0;
                /* width: 30px; */
                border-bottom: 2px solid #fff;
            }

            .inputbox label{
                position: absolute;
                top: 50%;
                left: 5px;
                transform: translateY(-50%);
                color: #fff; 
                font-size: 16px;
                pointer-events: none;
            }

            .inputbox input:focus ~ label,
            .inputbox input:valid ~ label{
                top: -5px;
                left: 0;
                color: #fff;
                font-size: 12px;
            }

            .inputbox input{
                width: 100%;
                padding: 5px 0;
                font-size: 16px;
                color: #fff;
                background: transparent;
                border: none;
                outline: none;
                resize: none;
            }

            .emoji-space{
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 100px;
                background: #ffffff;
                border-radius: 0 0 10px 10px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .emoji-space #emoji-display{
                font-size: 80px;
            }

            #loading-container{
                position: absolute;
                top: 0;
                left: 0;
                width: 10%;
                height: 0%;
                color: #fff
                display: flex;
                justify-content: start;
                align-items: flex-start;
            }
        </style>
    </head>
    <body class="antialiased">
        <section>
            <div class="form-box">
                <div class="form-value">
                    <form action="">
                        <h2>Emoticon generator</h2>
                        <div class="p-6 bg-gray-50 border rounded-lg shadow-lg">
                            <div id="emoticon-container" >
                              <div class="flex justify-between items-center w-full inputbox">
                                <input
                                  type="text"
                                  class="p-2 text-lg focus:outline-none bg-transparent"
                                  value="{{ e('anger') }}"
                                />
                            </div>
                            <div id="loading-container" class="invisible">
                              <svg
                                fill="none"
                                class="h-8 w-8 animate-spin text-orange-600"
                                viewBox="0 0 32 32"
                                xmlns="http://www.w3.org/2000/svg"
                              >
                                <path
                                  clip-rule="evenodd"
                                  d="M15.165 8.53a.5.5 0 01-.404.58A7 7 0 1023 16a.5.5 0 011 0 8 8 0 11-9.416-7.874.5.5 0 01.58.404z"
                                  fill="currentColor"
                                  fill-rule="evenodd"
                                />
                              </svg>
                            </div>
                              <div class="emoji-space">
                                <p id="emoji-display" class="mt-4 text-center w-full text-9xl">🤬</p>
                              </div>
                            </div>
                          </div>                          
                    </form>
                </div>
            </div>
        </section>
    </body>
    <script>
        const emoticonForm = document.querySelector("#emoticon-container");
        const userInput = emoticonForm.querySelector('input[type="text"]');
        const emojiDisplay = emoticonForm.querySelector("p");
        userInput.addEventListener(
        "input",
        debounce((event) => {
            fetchEmoji();
        }, 500)
        );

        function fetchEmoji() {
            const userInput = emoticonForm.querySelector('input[type="text"]');
            const emojiDisplay = document.getElementById("emoji-display");
            const loadingContainer = document.querySelector("#loading-container");
            loadingContainer.classList.remove("invisible");

            fetch(`/api/emoji?content=${userInput.value}`, {
                method: "GET",
                headers: {
                "Content-Type": "application/json",
                },
            })
            .then((response) => response.json())
            .then(({ content }) => {
            emojiDisplay.innerText = content;
            loadingContainer.classList.add("invisible");
            })
            .catch((error) => console.error(error));
            console.log("fetching");
        }

        function debounce(callback, delay) {
        let timeoutId;

        return function () {
            const args = arguments;
            const context = this;

            clearTimeout(timeoutId);

            timeoutId = setTimeout(function () {
            callback.apply(context, args);
            }, delay);
        };
        }

    </script>
</html>
