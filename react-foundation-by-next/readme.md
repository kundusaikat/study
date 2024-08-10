url --> https://nextjs.org/learn/react-foundations

System requirements
Before you start this course, make sure you have the following installed:

- Node.js 20.12.0 or later installed.
- Operating systems: macOS, Windows (including WSL), or Linux.
- VSCode or another text editor of your choice.

# 1 About React and Next.js

Next.js is a flexible React framework that gives you building blocks to create fast, full-stack web applications.

But what exactly do we mean by this? Let's spend some time expanding on what React and Next.js are and how they can help you build web applications.

Building blocks of a web application
There are a few things you need to consider when building modern applications. Such as:

- User Interface - how users will consume and interact with your application.
- Routing - how users navigate between different parts of your application.
- Data Fetching - where your data lives and how to get it.
- Rendering - when and where you render static or dynamic content.
- Integrations - what third-party services you use (for CMS, auth, payments, etc.) and how you connect to them.
- Infrastructure - where you deploy, store, and run your application code (serverless, CDN, edge, etc.).
- Performance - how to optimize your application for end-users.
- Scalability - how your application adapts as your team, data, and traffic grow.
- Developer Experience - your team's experience building and maintaining your application.

For each part of your application, you will need to decide whether you will build a solution yourself or use other tools, such as packages, libraries, and frameworks.

React is a JavaScript library for building interactive user interfaces.

# 2: Rendering User Interfaces (UI)

What is the DOM?
The DOM is an object representation of the HTML elements. It acts as a bridge between your code and the user interface, and has a tree-like structure with parent and child relationships.

# 3: Updating UI with Javascript

```html
<html>
  <body>
    <div></div>
  </body>
</html>
```

Then give the div a unique id so that you can target it later.

```html
<html>
  <body>
    <div id="app"></div>
  </body>
</html>
```

To write JavaScript inside your HTML file, add a script tag:

```html
<html>
  <body>
    <div id="app"></div>
    <script type="text/javascript"></script>
  </body>
</html>
```

Now, inside the script tag, you can use a DOM method, `getElementById()`, to select the `<div>` element by its id:


```html
<html>
  <body>
    <div id="app"></div>
    <script type="text/javascript">
      const app = document.getElementById('app');
    </script>
  </body>
</html>
```

You can continue using DOM methods to create a new `<h1>` element:

```html
<html>
  <body>
    <div id="app"></div>
    <script type="text/javascript">
      // Select the div element with 'app' id
      const app = document.getElementById('app');
 
      // Create a new H1 element
      const header = document.createElement('h1');
 
      // Create a new text node for the H1 element
      const text = 'Develop. Preview. Ship.';
      const headerContent = document.createTextNode(text);
 
      // Append the text to the H1 element
      header.appendChild(headerContent);
 
      // Place the H1 element inside the div
      app.appendChild(header);
    </script>
  </body>
</html>
```

HTML vs. the DOM
If you look at the DOM elements inside your browser developer tools, you will notice the DOM includes the `<h1>` element. The DOM of the page is different from the source code - or in other words, the original HTML file you created.

This is because the HTML represents the initial page content, whereas the DOM represents the updated page content which was changed by the JavaScript code you wrote.

Updating the DOM with plain JavaScript is very powerful but verbose. You've written all this code to add an `<h1>` element with some text:

```html
<script type="text/javascript">
  const app = document.getElementById('app');
  const header = document.createElement('h1');
  const text = 'Develop. Preview. Ship.';
  const headerContent = document.createTextNode(text);
  header.appendChild(headerContent);
  app.appendChild(header);
</script>
```

Imperative vs. declarative programming


The code above is a good example of imperative programming. You're writing the steps for how the user interface should be updated. But when it comes to building user interfaces, a declarative approach is often preferred because it can speed up the development process. Instead of having to write DOM methods, it would be helpful if developers were able to declare what they want to show (in this case, an h1 tag with some text).

In other words, imperative programming is like giving a chef step-by-step instructions on how to make a pizza. Declarative programming is like ordering a pizza without being concerned about the steps it takes to make the pizza. 🍕

React is a popular declarative library that you can use build user interfaces.

# 4: Getting Started with React

To use React in your newly created project, load two React scripts from an external website called unpkg.com:

react is the core React library.
react-dom provides DOM-specific methods that enable you to use React with the DOM.

```html
<html>
  <body>
    <div id="app"></div>
    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script type="text/javascript">
      const app = document.getElementById('app');
      const header = document.createElement('h1');
      const text = 'Develop. Preview. Ship.';
      const headerContent = document.createTextNode(text);
      header.appendChild(headerContent);
      app.appendChild(header);
    </script>
  </body>
</html>
```

Instead of directly manipulating the DOM with plain JavaScript, remove the DOM methods that you had added previously, and add the `ReactDOM.createRoot()` method to target a specific DOM element and create a root to display your React Components in. Then, add the `root.render()` method to render your React code to the DOM.

```html
<html>
  <body>
    <div id="app"></div>
    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script>
      const app = document.getElementById('app');
      const root = ReactDOM.createRoot(app);
      root.render(<h1>Develop. Preview. Ship.</h1>);
    </script>
  </body>
</html>
```

What is JSX?

JSX is a syntax extension for JavaScript that allows you to describe your UI in a familiar HTML-like syntax. The nice thing about JSX is that apart from following three JSX rules, you don't need to learn any new symbols or syntax outside of HTML and JavaScript.

But browsers don't understand JSX out of the box, so you'll need a JavaScript compiler, such as a `Babel`, to transform your JSX code into regular JavaScript.

Adding Babel to your project

To add Babel to your project, copy and paste the following script in your index.html file:

```html
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
```

In addition, you will need to inform Babel what code to transform by changing the script type to type=text/jsx.

```html
<html>
  <body>
    <div id="app"></div>
    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <!-- Babel Script -->
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <script type="text/jsx">
      const domNode = document.getElementById('app');
      const root = ReactDOM.createRoot(domNode);
      root.render(<h1>Develop. Preview. Ship.</h1>);
    </script>
  </body>
</html>
```

# 5: Building UI with Components

React core concepts
There are three core concepts of React that you'll need to be familiar with to start building React applications. These are:

- Components
- Props
- State

```jsx
function Header() {
  return <h1>Develop. Preview. Ship.</h1>;
}
 
function HomePage() {
  return (
    <div>
      <Header />
    </div>
  );
}
 
const root = ReactDOM.createRoot(app);
root.render(<HomePage />);
```

# 6: Displaying Data with Props

```js
function HomePage() {
  return (
    <div>
      <Header title="React" />
    </div>
  );
}
```

```js
function Header(props) {
  console.log(props); // { title: "React" }
  return <h1>Develop. Preview. Ship.</h1>;
}
```

- An object property with dot notation:
```js
function Header(props) {
  return <h1>{props.title}</h1>;
}
```

- A template literal:
```js
function Header({ title }) {
  return <h1>{`Cool ${title}`}</h1>;
}
```

- The returned value of a function:
```js
function createTitle(title) {
  if (title) {
    return title;
  } else {
    return 'Default title';
  }
}
 
function Header({ title }) {
  return <h1>{createTitle(title)}</h1>;
}
```

- Or ternary operators:
```js
function Header({ title }) {
  return <h1>{title ? title : 'Default Title'}</h1>;
}
```

You can use the names for now since they are currently unique, but it's recommended to use something guaranteed to be unique, like an item ID.

`crypto.randomUUID()` or a package like uuid when creating items.
```js
function HomePage() {
  const names = ['Ada Lovelace', 'Grace Hopper', 'Margaret Hamilton'];
 
  return (
    <div>
      <Header title="Develop. Preview. Ship." />
      <ul>
        {names.map((name) => (
          <li key={name}>{name}</li>
        ))}
      </ul>
    </div>
  );
}
```

# 7: Adding Interactivity with State

```js
function HomePage() {
  // ...
  const [likes, setLikes] = React.useState(0);
 
  function handleClick() {
    setLikes(likes + 1);
  }
 
  return (
    <div>
      {/* ... */}
      <button onClick={handleClick}>Likes ({likes})</button>
    </div>
  );
}
```

# 8: From React to Next.js

```html
<html>
  <body>
    <div id="app"></div>
 
    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
 
    <script type="text/jsx">
      const app = document.getElementById("app")
 
      function Header({ title }) {
        return <h1>{title ? title : "Default title"}</h1>
      }
 
      function HomePage() {
        const names = ["Ada Lovelace", "Grace Hopper", "Margaret Hamilton"]
 
        const [likes, setLikes] = React.useState(0)
 
        function handleClick() {
          setLikes(likes + 1)
        }
 
        return (
          <div>
            <Header title="Develop. Preview. Ship." />
            <ul>
              {names.map((name) => (
                <li key={name}>{name}</li>
              ))}
            </ul>
 
            <button onClick={handleClick}>Like ({likes})</button>
          </div>
        )
      }
 
      const root = ReactDOM.createRoot(app);
      root.render(<HomePage />);
    </script>
  </body>
</html>
```

# 9: Installing Next.js

```bash
npm install react@latest react-dom@latest next@latest
```

Once the installation is complete, you should be able to see your project dependencies listed inside your `package.json` file:
```json
{
  "dependencies": {
    "next": "^14.0.3",
    "react": "^18.3.1",
    "react-dom": "^18.3.1"
  }
}
```

```js
import { useState } from 'react';
 
function Header({ title }) {
  return <h1>{title ? title : 'Default title'}</h1>;
}
 
function HomePage() {
  const names = ['Ada Lovelace', 'Grace Hopper', 'Margaret Hamilton'];
 
  const [likes, setLikes] = useState(0);
 
  function handleClick() {
    setLikes(likes + 1);
  }
 
  return (
    <div>
      <Header title="Develop. Preview. Ship." />
      <ul>
        {names.map((name) => (
          <li key={name}>{name}</li>
        ))}
      </ul>
 
      <button onClick={handleClick}>Like ({likes})</button>
    </div>
  );
}
```

Here's how you can create your first page in Next.js:

- Create a new folder called app and move the `index.js` file inside it.
- Rename your `index.js` file to `page.js`. This will be the main page of your application.
- Add export default to your `<HomePage>` component to help Next.js distinguish which component to render as the main component of the page.

```json
{
  "scripts": {
    "dev": "next dev"
  },
  "dependencies": {
    "next": "^14.0.3",
    "react": "^18.3.1",
    "react-dom": "^18.3.1"
  }
}
```

Check what happens by running npm run dev in your terminal. You'll notice two things:

When you navigate to localhost:3000, you should see the following error:

This is because Next.js uses React Server Components, a new feature that allows React to render on the server. Server Components don't support useState, so you'll need to use a Client Component instead.

In the next chapter, we'll discuss the main differences between Server and Client Components and fix this error.

A new file called layout.js was automatically created inside the app folder. This is the main layout of your application. You can use it to add UI elements that are shared across all pages (e.g. navigation, footer, etc).


```js
export const metadata = {
  title: 'Next.js',
  description: 'Generated by Next.js',
};
 
export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <body>{children}</body>
    </html>
  );
}
```

# 10: Server and Client Components

To understand how Server and Client Components work, it's helpful to be familiar with two foundational web concepts:

The environments your application code can be executed in: the server and the client.
The network boundary that separates server and client code.

- The client refers to the browser on a user’s device that sends a request to a server for your application code. It then turns the response it receives from the server into an interface the user can interact with.

- The server refers to the computer in a data center that stores your application code, receives requests from a client, does some computation, and sends back an appropriate response.

Using Client Components
As you learned in the last chapter, Next.js uses Server Components by default - this is to improve your application's performance and means you don't have to take additional steps to adopt them.

Looking back at the error in your browser, Next.js is warning you that you're trying to useState inside a Server Component. You can fix this by moving the interactive "Like" button to a Client Component.

Create a new file called like-button.js inside the app folder that exports a LikeButton component:

```js
'use client';
 
import { useState } from 'react';
 
export default function LikeButton() {
  const [likes, setLikes] = useState(0);
 
  function handleClick() {
    setLikes(likes + 1);
  }
 
  return <button onClick={handleClick}>Like ({likes})</button>;
}
```

# 11: Next Steps