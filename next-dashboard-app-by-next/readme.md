# Welcome to the Next.js App Router course! In this free interactive course, you'll learn the main features of Next.js by building a full-stack web application.

For this course, we'll be building a simplified version of the financial dashboard that has:

- A public home page.
- A login page.
- Dashboard pages that are protected by authentication.
- The ability for users to add, edit, and delete invoices.

Here's an overview of features you'll learn about in this course:

- Styling: The different ways to style your application in Next.js.
- Optimizations: How to optimize images, links, and fonts.
- Routing: How to create nested layouts and pages using file-system routing.
- Data Fetching: How to set up a database on Vercel, and best practices for fetching and streaming.
- Search and Pagination: How to implement search and pagination using URL Search Params.
- Mutating Data: How to mutate data using React Server Actions, and revalidate the Next.js cache.
- Error Handling: How to handle general and 404 not found errors.
- Form Validation and Accessibility: How to do server-side form validation and tips for improving accessibility.
- Authentication: How to add authentication to your application using NextAuth.js and Middleware.
- Metadata: How to add metadata and prepare your application for social sharing.

# 1: Getting Started

Creating a new project

We recommend using `pnpm` as your package manager, as it's faster and more efficient than `npm` or `yarn`. If you don't have `pnpm` installed, you can install it globally by running:

```sh
npm install -g pnpm
```

```sh
npx create-next-app@latest nextjs-dashboard --example "https://github.com/vercel/next-learn/tree/main/dashboard/starter-example" --use-pnpm
```

```sh
cd nextjs-dashboard
```

Folder structure

You'll notice that the project has the following folder structure:

- `/app`: Contains all the routes, components, and logic for your application, this is where you'll be mostly working from.
- `/app/lib`: Contains functions used in your application, such as reusable utility functions and data fetching functions.
- `/app/ui`: Contains all the UI components for your application, such as cards, tables, and forms. To save time, we've pre-styled these components for you.
- `/public`: Contains all the static assets for your application, such as images.
- Config Files: You'll also notice config files such as `next.config.js` at the root of your application. Most of these files are created and pre-configured when you start a new project using create-next-app. You will not need to modify them in this course.

Placeholder data

When you're building user interfaces, it helps to have some placeholder data. If a database or API is not yet available, you can:

Use placeholder data in JSON format or as JavaScript objects.
Use a 3rd party service like ` mockAPI`.

For this project, we've provided some placeholder data in `app/lib/placeholder-data.ts`. Each JavaScript object in the file represents a table in your database. For example, for the invoices table:

TypeScript

You may also notice most files have a `.ts` or `.tsx` suffix. This is because the project is written in TypeScript. We wanted to create a course that reflects the modern web landscape.

It's okay if you don't know TypeScript - we'll provide the TypeScript code snippets when required.

For now, take a look at the `/app/lib/definitions.ts` file. Here, we manually define the types that will be returned from the database. For example, the invoices table has the following types:

If you're a TypeScript developer:

We're manually declaring the data types, but for better type-safety, we recommend `Prisma` or `Drizzle`, which automatically generates types based on your database schema.

Next.js detects if your project uses TypeScript and automatically installs the necessary packages and configuration. Next.js also comes with a TypeScript plugin for your code editor, to help with auto-completion and type-safety.

```sh
pnpm i
```

```sh
pnpm dev
```

# 2: CSS Styling

In this chapter...

Here are the topics we’ll cover

- How to add a global CSS file to your application.

- Two different ways of styling: Tailwind and CSS modules.

- How to conditionally add class names with the clsx utility package.

`/app/layout.tsx`
```jsx
import '@/app/ui/global.css';
 
export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en">
      <body>{children}</body>
    </html>
  );
}
```

`/app/ui/global.css`
```jsx
@tailwind base;
@tailwind components;
@tailwind utilities;
```

`/app/page.tsx`
```jsx
<div
  className="relative w-0 h-0 border-l-[15px] border-r-[15px] border-b-[26px] border-l-transparent border-r-transparent border-b-black"
/>
```

CSS Modules

CSS Modules allow you to scope CSS to a component by automatically creating unique class names, so you don't have to worry about style collisions as well.

We'll continue using Tailwind in this course, but let's take a moment to see how you can achieve the same results from the quiz above using CSS modules.

Inside `/app/ui`, create a new file called `home.module.css` and add the following CSS rules:

`/app/ui/home.module.css`
```css
.shape {
  height: 0;
  width: 0;
  border-bottom: 30px solid black;
  border-left: 20px solid transparent;
  border-right: 20px solid transparent;
}
```

`/app/page.tsx`
```jsx
import AcmeLogo from '@/app/ui/acme-logo';
import { ArrowRightIcon } from '@heroicons/react/24/outline';
import Link from 'next/link';
import styles from '@/app/ui/home.module.css';
 
export default function Page() {
  return (
    <main className="flex min-h-screen flex-col p-6">
      <div className={styles.shape} />
    // ...
  )
}
```

Using the clsx library to toggle class names
There may be cases where you may need to conditionally style an element based on state or some other condition.

clsx is a library that lets you toggle class names easily. We recommend taking a look at documentation for more details, but here's the basic usage:

Suppose that you want to create an InvoiceStatus component which accepts status. The status can be 'pending' or 'paid'.
If it's 'paid', you want the color to be green. If it's 'pending', you want the color to be gray.

You can use clsx to conditionally apply the classes, like this:
`/app/ui/invoices/status.tsx`
```jsx
import clsx from 'clsx';
 
export default function InvoiceStatus({ status }: { status: string }) {
  return (
    <span
      className={clsx(
        'inline-flex items-center rounded-full px-2 py-1 text-sm',
        {
          'bg-gray-100 text-gray-500': status === 'pending',
          'bg-green-500 text-white': status === 'paid',
        },
      )}
    >
    // ...
)}
```

Other styling solutions

In addition to the approaches we've discussed, you can also style your Next.js application with:

Sass which allows you to import .css and .scss files.

CSS-in-JS libraries such as styled-jsx, styled-components, and emotion.

# 3: Optimizing Fonts and Images

In this chapter...

Here are the topics we’ll cover

- How to add custom fonts with next/font.

- How to add images with next/image.

- How fonts and images are optimized in Next.js.

Why optimize fonts?
Fonts play a significant role in the design of a website, but using custom fonts in your project can affect performance if the font files need to be fetched and loaded.

`Cumulative Layout Shift` is a metric used by Google to evaluate the performance and user experience of a website. With fonts, layout shift happens when the browser initially renders text in a fallback or system font and then swaps it out for a custom font once it has loaded. This swap can cause the text size, spacing, or layout to change, shifting elements around it.

Next.js automatically optimizes fonts in the application when you use the next/font module. It downloads font files at build time and hosts them with your other static assets. This means when a user visits your application, there are no additional network requests for fonts which would impact performance.

Adding a primary font
Let's add a custom Google font to your application to see how this works!

In your /app/ui folder, create a new file called fonts.ts. You'll use this file to keep the fonts that will be used throughout your application.

Import the Inter font from the next/font/google module - this will be your primary font. Then, specify what subset you'd like to load. In this case, 'latin':

`/app/ui/fonts.ts`
```jsx
import { Inter } from 'next/font/google';
 
export const inter = Inter({ subsets: ['latin'] });
```

Finally, add the font to the <body> element in /app/layout.tsx:
`/app/layout.tsx`
```jsx
import '@/app/ui/global.css';
import { inter } from '@/app/ui/fonts';
 
export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en">
      <body className={`${inter.className} antialiased`}>{children}</body>
    </html>
  );
}
```

By adding Inter to the `<body>` element, the font will be applied throughout your application. Here, you're also adding the Tailwind antialiased class which smooths out the font. It's not necessary to use this class, but it adds a nice touch.

Navigate to your browser, open dev tools and select the body element. You should see Inter and Inter_Fallback are now applied under styles.

Practice: Adding a secondary font

You can also add fonts to specific elements of your application.

Now it's your turn! In your fonts.ts file, import a secondary font called Lusitana and pass it to the `<p>` element in your `/app/page.tsx file`. In addition to specifying a subset like you did before, you'll also need to specify the font weight.

`/app/ui/fonts.ts`
```tsx
import { Inter, Lusitana } from 'next/font/google';
 
export const inter = Inter({ subsets: ['latin'] });
 
export const lusitana = Lusitana({
  weight: ['400', '700'],
  subsets: ['latin'],
});
```

`/app/page.tsx`
```tsx
import AcmeLogo from '@/app/ui/acme-logo';
import { ArrowRightIcon } from '@heroicons/react/24/outline';
import Link from 'next/link';
import { lusitana } from '@/app/ui/fonts';
 
export default function Page() {
  return (
    // ...
    <p
      className={`${lusitana.className} text-xl text-gray-800 md:text-3xl md:leading-normal`}
    >
      <strong>Welcome to Acme.</strong> This is the example for the{' '}
      <a href="https://nextjs.org/learn/" className="text-blue-500">
        Next.js Learn Course
      </a>
      , brought to you by Vercel.
    </p>
    // ...
  );
}
```

Finally, the `<AcmeLogo />` component also uses Lusitana. It was commented out to prevent errors, you can now uncomment it:

Why optimize images?

Next.js can serve static assets, like images, under the top-level `/public` folder. Files inside `/public` can be referenced in your application.

With regular HTML, you would add an image as follows:

```html
<img
  src="/hero.png"
  alt="Screenshots of the dashboard project showing desktop version"
/>
```

The `<Image>` component
The `<Image>` Component is an extension of the HTML `<img>` tag, and comes with automatic image optimization, such as:

Preventing layout shift automatically when images are loading.
Resizing images to avoid shipping large images to devices with a smaller viewport.
Lazy loading images by default (images load as they enter the viewport).
Serving images in modern formats, like `WebP` and `AVIF`, when the browser supports it.

Adding the desktop hero image
Let's use the `<Image>` component. If you look inside the `/public` folder, you'll see there are two images: `hero-desktop.png` and `hero-mobile.png`. These two images are completely different, and they'll be shown depending if the user's device is a desktop or mobile.

In your `/app/page.tsx` file, import the component from `next/image`. Then, add the image under the comment:

`/app/page.tsx`
```tsx
import AcmeLogo from '@/app/ui/acme-logo';
import { ArrowRightIcon } from '@heroicons/react/24/outline';
import Link from 'next/link';
import { lusitana } from '@/app/ui/fonts';
import Image from 'next/image';
 
export default function Page() {
  return (
    // ...
    <div className="flex items-center justify-center p-6 md:w-3/5 md:px-28 md:py-12">
      {/* Add Hero Images Here */}
      <Image
        src="/hero-desktop.png"
        width={1000}
        height={760}
        className="hidden md:block"
        alt="Screenshots of the dashboard project showing desktop version"
      />
    </div>
    //...
  );
}
```

# 4: Creating Layouts and Pages

In this chapter...

Here are the topics we’ll cover

- Create the dashboard routes using file-system routing.

- Understand the role of folders and files when creating new route segments.

- Create a nested layout that can be shared between multiple dashboard pages.

- Understand what colocation, partial rendering, and the root layout are.

Nested routing

Next.js uses file-system routing where folders are used to create nested routes. Each folder represents a route segment that maps to a URL segment.

You can create separate UIs for each route using layout.tsx and page.tsx files.

page.tsx is a special Next.js file that exports a React component, and it's required for the route to be accessible. In your application, you already have a page file: /app/page.tsx - this is the home page associated with the route /.

To create a nested route, you can nest folders inside each other and add page.tsx files inside them. For example:

Creating the dashboard page
`/app/dashboard/page.tsx`
```tsx
export default function Page() {
  return <p>Dashboard Page</p>;
}
```

`/app/dashboard/layout.tsx`
```tsx
import SideNav from '@/app/ui/dashboard/sidenav';
 
export default function Layout({ children }: { children: React.ReactNode }) {
  return (
    <div className="flex h-screen flex-col md:flex-row md:overflow-hidden">
      <div className="w-full flex-none md:w-64">
        <SideNav />
      </div>
      <div className="flex-grow p-6 md:overflow-y-auto md:p-12">{children}</div>
    </div>
  );
}
```

# 5: Navigating Between Pages

In this chapter...

Here are the topics we’ll cover

- How to use the next/link component.

- How to show an active link with the usePathname() hook.

- How navigation works in Next.js.

Why optimize navigation?
To link between pages, you'd traditionally use the `<a>` HTML element. At the moment, the sidebar links use `<a>` elements, but notice what happens when you navigate between the home, invoices, and customers pages on your browser.

Did you see it?

There's a full page refresh on each page navigation!

The `<Link>` component

In Next.js, you can use the `<Link />` Component to link between pages in your application. `<Link>` allows you to do client-side navigation with JavaScript.

To use the `<Link />` component, open `/app/ui/dashboard/nav-links.tsx`, and import the Link component from next/link. Then, replace the `<a>` tag with `<Link>`:

As you can see, the Link component is similar to using `<a>` tags, but instead of `<a href="…">`, you use `<Link href="…">`.

Automatic code-splitting and prefetching
To improve the navigation experience, Next.js automatically code splits your application by route segments. This is different from a traditional React SPA, where the browser loads all your application code on initial load.

Splitting code by routes means that pages become isolated. If a certain page throws an error, the rest of the application will still work.

Furthermore, in production, whenever `<Link>` components appear in the browser's viewport, Next.js automatically prefetches the code for the linked route in the background. By the time the user clicks the link, the code for the destination page will already be loaded in the background, and this is what makes the page transition near-instant!

Pattern: Showing active links

A common UI pattern is to show an active link to indicate to the user what page they are currently on. To do this, you need to get the user's current path from the URL. Next.js provides a hook called `usePathname()` that you can use to check the path and implement this pattern.

Since `usePathname()` is a hook, you'll need to turn nav-links.tsx into a Client Component. Add React's "use client" directive to the top of the file, then import `usePathname()` from next/navigation:

`/app/ui/dashboard/nav-links.tsx`
```tsx
'use client';
 
import {
  UserGroupIcon,
  HomeIcon,
  DocumentDuplicateIcon,
} from '@heroicons/react/24/outline';
import Link from 'next/link';
import { usePathname } from 'next/navigation';
import clsx from 'clsx';
 
// ...
 
export default function NavLinks() {
  const pathname = usePathname();
 
  return (
    <>
      {links.map((link) => {
        const LinkIcon = link.icon;
        return (
          <Link
            key={link.name}
            href={link.href}
            className={clsx(
              'flex h-[48px] grow items-center justify-center gap-2 rounded-md bg-gray-50 p-3 text-sm font-medium hover:bg-sky-100 hover:text-blue-600 md:flex-none md:justify-start md:p-2 md:px-3',
              {
                'bg-sky-100 text-blue-600': pathname === link.href,
              },
            )}
          >
            <LinkIcon className="w-6" />
            <p className="hidden md:block">{link.name}</p>
          </Link>
        );
      })}
    </>
  );
}
```

# 6: Setting Up Your Database

In this chapter...

Here are the topics we’ll cover

- Push your project to GitHub.

- Set up a Vercel account and link your GitHub repo for instant previews and deployments.

- Create and link your project to a Postgres database.

- Seed the database with initial data.

Steps
- Create a GitHub repository
- Create a Vercel account
- Connect and deploy your project
- Create a Postgres database
Next, to set up a database, click Continue to Dashboard and select the Storage tab from your project dashboard. Select Connect Store → Create New → Postgres → Continue.

Accept the terms, assign a name to your database, and ensure your database region is set to Washington D.C (iad1) - this is also the default region for all new Vercel projects. By placing your database in the same region or close to your application code, you can reduce latency for data requests.

Good to know: You cannot change the database region once it has been initalized. If you wish to use a different region, you should set it before creating a database.

Once connected, navigate to the .env.local tab, click Show secret and Copy Snippet. Make sure you reveal the secrets before copying them.

Navigate to your code editor and rename the .env.example file to .env. Paste in the copied contents from Vercel.

Important: Go to your .gitignore file and make sure .env is in the ignored files to prevent your database secrets from being exposed when you push to GitHub.

Finally, run `pnpm i @vercel/postgres` in your terminal to install the Vercel Postgres SDK.

Seed your database

Now that your database has been created, let's seed it with some initial data.

Inside of /app, there's a folder called seed. Uncomment this file. This folder contains a Next.js Route Handler, called route.ts, that will be used to seed your database. This creates a server-side endpoint that you can access in the browser to start populating your database.

Don't worry if you don't understand everything the code is doing, but to give you an overview, the script uses SQL to create the tables, and the data from placeholder-data.ts file to populate them after they've been created.

Ensure your local development server is running with pnpm run dev and navigate to localhost:3000/seed in your browser. When finished, you will see a message "Database seeded successfully" in the browser. Once completed, you can delete this file.

Troubleshooting:

Make sure to reveal your database secrets before copying it into your .env file.
The script uses bcrypt to hash the user's password, if bcrypt isn't compatible with your environment, you can update the script to use bcryptjs instead.

If you run into any issues while seeding your database and want to run the script again, you can drop any existing tables by running DROP TABLE tablename in your database query interface. See the executing queries section below for more details. But be careful, this command will delete the tables and all their data. It's ok to do this with your example app since you're working with placeholder data, but you shouldn't run this command in a production app.

If you continue to experience issues while seeding your Vercel Postgres database, please open a discussion on GitHub.

Exploring your database

Let's see what your database looks like. Go back to Vercel, and click Data on the sidenav.

In this section, you'll find the four new tables: users, customers, invoices, and revenue.

Executing queries

You can switch to the "query" tab to interact with your database. This section supports standard SQL commands. For instance, inputting DROP TABLE customers will delete "customers" table along with all its data - so be careful!

Let's run your first database query. Paste and run the following SQL code into the Vercel interface:

SELECT invoices.amount, customers.name
FROM invoices
JOIN customers ON invoices.customer_id = customers.id
WHERE invoices.amount = 666;

# 7: Fetching Data

In this chapter...

Here are the topics we’ll cover

- Learn about some approaches to fetching data: APIs, ORMs, SQL, etc.

- How Server Components can help you access back-end resources more securely.

- What network waterfalls are.

- How to implement parallel data fetching using a JavaScript Pattern.

Choosing how to fetch data

API layer

APIs are an intermediary layer between your application code and database. There are a few cases where you might use an API:

If you're using 3rd party services that provide an API.
If you're fetching data from the client, you want to have an API layer that runs on the server to avoid exposing your database secrets to the client.
In Next.js, you can create API endpoints using Route Handlers.

Database queries

When you're creating a full-stack application, you'll also need to write logic to interact with your database. For relational databases like Postgres, you can do this with SQL or with an ORM.

There are a few cases where you have to write database queries:

When creating your API endpoints, you need to write logic to interact with your database.
If you are using React Server Components (fetching data on the server), you can skip the API layer, and query your database directly without risking exposing your database secrets to the client.

Using Server Components to fetch data

By default, Next.js applications use React Server Components. Fetching data with Server Components is a relatively new approach and there are a few benefits of using them:

Server Components support promises, providing a simpler solution for asynchronous tasks like data fetching. You can use async/await syntax without reaching out for useEffect, useState or data fetching libraries.

Server Components execute on the server, so you can keep expensive data fetches and logic on the server and only send the result to the client.

As mentioned before, since Server Components execute on the server, you can query the database directly without an additional API layer.

Using SQL

For your dashboard project, you'll write database queries using the Vercel Postgres SDK and SQL. There are a few reasons why we'll be using SQL:

- SQL is the industry standard for querying relational databases (e.g. ORMs generate SQL under the hood).

- Having a basic understanding of SQL can help you understand the fundamentals of relational databases, allowing you to apply your knowledge to other tools.

- SQL is versatile, allowing you to fetch and manipulate specific data.

- The Vercel Postgres SDK provides protection against SQL injections.

Don't worry if you haven't used SQL before - we have provided the queries for you.

Go to /app/lib/data.ts, here you'll see that we're importing the sql function from @vercel/postgres. This function allows you to query your database:

Fetching data for the dashboard overview page
Now that you understand different ways of fetching data, let's fetch data for the dashboard overview page. Navigate to /app/dashboard/page.tsx, paste the following code, and spend some time exploring it:

In the code above:

Page is an async component. This allows you to use await to fetch data.
There are also 3 components which receive data: `<Card>`, `<RevenueChart>`, and `<LatestInvoices>`. They are currently commented out to prevent the application from erroring.

Fetching data for `<RevenueChart/>`

To fetch data for the `<RevenueChart/>`component, import the fetchRevenue function from data.ts and call it inside your component:

`/app/dashboard/page.tsx`
```tsx
import { Card } from '@/app/ui/dashboard/cards';
import RevenueChart from '@/app/ui/dashboard/revenue-chart';
import LatestInvoices from '@/app/ui/dashboard/latest-invoices';
import { lusitana } from '@/app/ui/fonts';
import { fetchRevenue } from '@/app/lib/data';
 
export default async function Page() {
  const revenue = await fetchRevenue();
  // ...
}
```

Fetching data for `<LatestInvoices/>`

For the `<LatestInvoices />` component, we need to get the latest 5 invoices, sorted by date.

You could fetch all the invoices and sort through them using JavaScript. This isn't a problem as our data is small, but as your application grows, it can significantly increase the amount of data transferred on each request and the JavaScript required to sort through it.

Instead of sorting through the latest invoices in-memory, you can use an SQL query to fetch only the last 5 invoices. For example, this is the SQL query from your data.ts file:


``
```tsx
// Fetch the last 5 invoices, sorted by date
const data = await sql<LatestInvoiceRaw>`
  SELECT invoices.amount, customers.name, customers.image_url, customers.email
  FROM invoices
  JOIN customers ON invoices.customer_id = customers.id
  ORDER BY invoices.date DESC
  LIMIT 5`;
```

```tsx
export async function fetchCardData() {
  try {
    const invoiceCountPromise = sql`SELECT COUNT(*) FROM invoices`;
    const customerCountPromise = sql`SELECT COUNT(*) FROM customers`;
    const invoiceStatusPromise = sql`SELECT
         SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END) AS "paid",
         SUM(CASE WHEN status = 'pending' THEN amount ELSE 0 END) AS "pending"
         FROM invoices`;
 
    const data = await Promise.all([
      invoiceCountPromise,
      customerCountPromise,
      invoiceStatusPromise,
    ]);
    // ...
  }
}
```

# 8: Static and Dynamic Rendering

In this chapter...

Here are the topics we’ll cover

- What static rendering is and how it can improve your application's performance.

- What dynamic rendering is and when to use it.

- Different approaches to make your dashboard dynamic.

- Simulate a slow data fetch to see what happens.

What is Static Rendering?
With static rendering, data fetching and rendering happens on the server at build time (when you deploy) or when revalidating data.

Whenever a user visits your application, the cached result is served. There are a couple of benefits of static rendering:

- Faster Websites - Prerendered content can be cached and globally distributed. This ensures that users around the world can access your website's content more quickly and reliably.
Reduced Server Load - Because the content is cached, your server does not have to dynamically generate content for each user request.
- SEO - Prerendered content is easier for search engine crawlers to index, as the content is already available when the page loads. This can lead to improved search engine rankings.
- Static rendering is useful for UI with no data or data that is shared across users, such as a static blog post or a product page. It might not be a good fit for a dashboard that has personalized data which is regularly updated.

The opposite of static rendering is dynamic rendering.

What is Dynamic Rendering?
With dynamic rendering, content is rendered on the server for each user at request time (when the user visits the page). There are a couple of benefits of dynamic rendering:

- Real-Time Data - Dynamic rendering allows your application to display real-time or frequently updated data. This is ideal for applications where data changes often.
- User-Specific Content - It's easier to serve personalized content, such as dashboards or user profiles, and update the data based on user interaction.
- Request Time Information - Dynamic rendering allows you to access information that can only be known at request time, such as cookies or the URL search parameters.

Simulating a Slow Data Fetch

The dashboard application we're building is dynamic.

However, there is still one problem mentioned in the previous chapter. What happens if one data request is slower than all the others?

Let's simulate a slow data fetch. In your data.ts file, uncomment the console.log and setTimeout inside fetchRevenue():

# 9: Streaming

In this chapter...

Here are the topics we’ll cover

- What streaming is and when you might use it.

- How to implement streaming with loading.tsx and Suspense.

- What loading skeletons are.

- What route groups are, and when you might use them.

- Where to place Suspense boundaries in your application.

What is streaming?

Streaming is a data transfer technique that allows you to break down a route into smaller "chunks" and progressively stream them from the server to the client as they become ready.

By streaming, you can prevent slow data requests from blocking your whole page. This allows the user to see and interact with parts of the page without waiting for all the data to load before any UI can be shown to the user.

Streaming works well with React's component model, as each component can be considered a chunk.

There are two ways you implement streaming in Next.js:

At the page level, with the loading.tsx file.
For specific components, with `<Suspense>`.

A few things are happening here:

loading.tsx is a special Next.js file built on top of Suspense, it allows you to create fallback UI to show as a replacement while page content loads.
Since `<SideNav>` is static, it's shown immediately. The user can interact with `<SideNav>` while the dynamic content is loading.
The user doesn't have to wait for the page to finish loading before navigating away (this is called interruptable navigation).
Congratulations! You've just implemented streaming. But we can do more to improve the user experience. Let's show a loading skeleton instead of the Loading… text.

Adding loading skeletons

A loading skeleton is a simplified version of the UI. Many websites use them as a placeholder (or fallback) to indicate to users that the content is loading. Any UI you add in loading.tsx will be embedded as part of the static file, and sent first. Then, the rest of the dynamic content will be streamed from the server to the client.

Inside your loading.tsx file, import a new component called `<DashboardSkeleton>`:

Fixing the loading skeleton bug with route groups
Right now, your loading skeleton will apply to the invoices and customers pages as well.

Since loading.tsx is a level higher than /invoices/page.tsx and /customers/page.tsx in the file system, it's also applied to those pages.

We can change this with Route Groups. Create a new folder called /(overview) inside the dashboard folder. Then, move your loading.tsx and page.tsx files inside the folder:

Now, the loading.tsx file will only apply to your dashboard overview page.

Route groups allow you to organize files into logical groups without affecting the URL path structure. When you create a new folder using parentheses (), the name won't be included in the URL path. So /dashboard/(overview)/page.tsx becomes /dashboard.

Here, you're using a route group to ensure loading.tsx only applies to your dashboard overview page. However, you can also use route groups to separate your application into sections (e.g. (marketing) routes and (shop) routes) or by teams for larger applications.

Streaming a component

So far, you're streaming a whole page. But you can also be more granular and stream specific components using React Suspense.

Suspense allows you to defer rendering parts of your application until some condition is met (e.g. data is loaded). You can wrap your dynamic components in Suspense. Then, pass it a fallback component to show while the dynamic component loads.

If you remember the slow data request, fetchRevenue(), this is the request that is slowing down the whole page. Instead of blocking your whole page, you can use Suspense to stream only this component and immediately show the rest of the page's UI.

To do so, you'll need to move the data fetch to the component, let's update the code to see what that'll look like:

Delete all instances of fetchRevenue() and its data from /dashboard/(overview)/page.tsx:

Grouping components

Great! You're almost there, now you need to wrap the `<Card>` components in Suspense. You can fetch data for each individual card, but this could lead to a popping effect as the cards load in, this can be visually jarring for the user.

So, how would you tackle this problem?

To create more of a staggered effect, you can group the cards using a wrapper component. This means the static `<SideNav/>` will be shown first, followed by the cards, etc.

In your page.tsx file:

Delete your `<Card>` components.
Delete the fetchCardData() function.
Import a new wrapper component called `<CardWrapper />`.
Import a new skeleton component called `<CardsSkeleton />`.
Wrap `<CardWrapper />` in Suspense.

Deciding where to place your Suspense boundaries

Where you place your Suspense boundaries will depend on a few things:

How you want the user to experience the page as it streams.
What content you want to prioritize.
If the components rely on data fetching.
Take a look at your dashboard page, is there anything you would've done differently?

Don't worry. There isn't a right answer.

You could stream the whole page like we did with loading.tsx... but that may lead to a longer loading time if one of the components has a slow data fetch.
You could stream every component individually... but that may lead to UI popping into the screen as it becomes ready.
You could also create a staggered effect by streaming page sections. But you'll need to create wrapper components.
Where you place your suspense boundaries will vary depending on your application. In general, it's good practice to move your data fetches down to the components that need it, and then wrap those components in Suspense. But there is nothing wrong with streaming the sections or the whole page if that's what your application needs.

Don't be afraid to experiment with Suspense and see what works best, it's a powerful API that can help you create more delightful user experiences.

# 10: Partial Prerendering

In this chapter...

Here are the topics we’ll cover

- What Partial Prerendering is.

- How Partial Prerendering works.

## Static vs. Dynamic Routes
For most web apps built today, you either choose between static and dynamic rendering for your entire application, or for a specific route. And in Next.js, if you call a dynamic function in a route (like querying your database), the entire route becomes dynamic.

However, most routes are not fully static or dynamic. For example, consider an ecommerce site. You might want to statically render the majority of the product information page, but you may want to fetch the user's cart and recommended products dynamically, this allows you show personalized content to your users.

Going back to your dashboard page, what components would you consider static vs. dynamic?

Once you're ready, click the button below to see how we would split the dashboard route:

The `<SideNav>` Component doesn't rely on data and is not personalized to the user, so it can be static.
The components in `<Page>` rely on data that changes often and will be personalized to the user, so they can be dynamic.

## What is Partial Prerendering?
Next.js 14 introduced an experimental version of Partial Prerendering – a new rendering model that allows you to combine the benefits of static and dynamic rendering in the same route. For example:

When a user visits a route:

- A static route shell that includes the navbar and product information is served, ensuring a fast initial load.
- The shell leaves holes where dynamic content like the cart and recommended products will load in asynchronously.
- The async holes are streamed in parallel, reducing the overall load time of the page.

## How does Partial Prerendering work?
Partial Prerendering uses React's Suspense (which you learned about in the previous chapter) to defer rendering parts of your application until some condition is met (e.g. data is loaded).

The Suspense fallback is embedded into the initial HTML file along with the static content. At build time (or during revalidation), the static content is prerendered to create a static shell. The rendering of dynamic content is postponed until the user requests the route.

Wrapping a component in Suspense doesn't make the component itself dynamic, but rather Suspense is used as a boundary between your static and dynamic code.

Let's see how you can implement PPR in your dashboard route.

## Implementing Partial Prerendering
Enable PPR for your Next.js app by adding the ppr option to your next.config.mjs file:

`next.config.mjs`
```js
/** @type {import('next').NextConfig} */
 
const nextConfig = {
  experimental: {
    ppr: 'incremental',
  },
};
 
export default nextConfig;
```

The 'incremental' value allows you to adopt PPR for specific routes.

Next, add the experimental_ppr segment config option to your dashboard layout:

`/app/dashboard/layout.tsx`
```tsx
import SideNav from '@/app/ui/dashboard/sidenav';
 
export const experimental_ppr = true;
 
// ...
```

That's it. You may not see a difference in your application in development, but you should notice a performance improvement in production. Next.js will prerender the static parts of your route and defer the dynamic parts until the user requests them.

The great thing about Partial Prerendering is that you don't need to change your code to use it. As long as you're using Suspense to wrap the dynamic parts of your route, Next.js will know which parts of your route are static and which are dynamic.

We believe PPR has the potential to become the default rendering model for web applications, bringing together the best of static site and dynamic rendering. However, it is still experimental. We hope to stabilize it in the future and make it the default way of building with Next.js.

Summary
To recap, you've done a few things to optimize data fetching in your application:

1. Created a database in the same region as your pplication code to reduce latency between your server and database.
2. Fetched data on the server with React Server Components. This allows you to keep expensive data fetches and logic on the server, reduces the client-side JavaScript bundle, and prevents your database secrets from being exposed to the client.
3. Used SQL to only fetch the data you needed, reducing the amount of data transferred for each request and the amount of JavaScript needed to transform the data in-memory.
4. Parallelize data fetching with JavaScript - where it made sense to do so.
5. Implemented Streaming to prevent slow data requests from blocking your whole page, and to allow the user to start interacting with the UI without waiting for everything to load.
6. Move data fetching down to the components that need it, thus isolating which parts of your routes should be dynamic.


In the next chapter, we'll look at two common patterns you might need to implement when fetching data: search and pagination.

# 11: Adding Search and Pagination

In this chapter...

Here are the topics we’ll cover

- Learn how to use the Next.js APIs: useSearchParams, usePathname, and useRouter.

- Implement search and pagination using URL search params.

## Why use URL search params?
As mentioned above, you'll be using URL search params to manage the search state. This pattern may be new if you're used to doing it with client side state.

There are a couple of benefits of implementing search with URL params:

Bookmarkable and Shareable URLs: Since the search parameters are in the URL, users can bookmark the current state of the application, including their search queries and filters, for future reference or sharing.
Server-Side Rendering and Initial Load: URL parameters can be directly consumed on the server to render the initial state, making it easier to handle server rendering.
Analytics and Tracking: Having search queries and filters directly in the URL makes it easier to track user behavior without requiring additional client-side logic.

## Adding the search functionality
These are the Next.js client hooks that you'll use to implement the search functionality:

- useSearchParams- Allows you to access the parameters of the current URL. For example, the search params for this URL /dashboard/invoices?page=1&query=pending would look like this: {page: '1', query: 'pending'}.
- usePathname - Lets you read the current URL's pathname. For example, for the route /dashboard/invoices, usePathname would return '/dashboard/invoices'.
- useRouter - Enables navigation between routes within client components programmatically. There are multiple methods you can use.
Here's a quick overview of the implementation steps:

Capture the user's input.
Update the URL with the search params.
Keep the URL in sync with the input field.
Update the table to reflect the search query.
1. Capture the user's input
Go into the `<Search>` Component (/app/ui/search.tsx), and you'll notice:

"use client" - This is a Client Component, which means you can use event listeners and hooks.
`<input>` - This is the search input.
Create a new handleSearch function, and add an onChange listener to the `<input>` element. onChange will invoke handleSearch whenever the input value changes.

`/app/ui/search.tsx`
```tsx
'use client';
 
import { MagnifyingGlassIcon } from '@heroicons/react/24/outline';
import { useSearchParams, usePathname, useRouter } from 'next/navigation';
 
export default function Search() {
  const searchParams = useSearchParams();
  const pathname = usePathname();
  const { replace } = useRouter();
 
  function handleSearch(term: string) {
    const params = new URLSearchParams(searchParams);
    if (term) {
      params.set('query', term);
    } else {
      params.delete('query');
    }
    replace(`${pathname}?${params.toString()}`);
  }
}
```
Here's a breakdown of what's happening:

```ts
${pathname} is the current path, in your case, "/dashboard/invoices".
As the user types into the search bar, params.toString() translates this input into a URL-friendly format.
replace(${pathname}?${params.toString()}) updates the URL with the user's search data. For example, /dashboard/invoices?query=lee if the user searches for "Lee".
The URL is updated without reloading the page, thanks to Next.js's client-side navigation (which you learned about in the chapter on navigating between pages.
```

## 3. Keeping the URL and input in sync
To ensure the input field is in sync with the URL and will be populated when sharing, you can pass a defaultValue to input by reading from searchParams:

`/app/ui/search.tsx`
```tsx
<input
  className="peer block w-full rounded-md border border-gray-200 py-[9px] pl-10 text-sm outline-2 placeholder:text-gray-500"
  placeholder={placeholder}
  onChange={(e) => {
    handleSearch(e.target.value);
  }}
  defaultValue={searchParams.get('query')?.toString()}
/>
```

defaultValue vs. value / Controlled vs. Uncontrolled

If you're using state to manage the value of an input, you'd use the value attribute to make it a controlled component. This means React would manage the input's state.

However, since you're not using state, you can use defaultValue. This means the native input will manage its own state. This is okay since you're saving the search query to the URL instead of state.

# 4. Updating the table

Finally, you need to update the table component to reflect the search query.

Navigate back to the invoices page.

Page components accept a prop called searchParams, so you can pass the current URL params to the `<Table>` component.

If you navigate to the `<Table>` Component, you'll see that the two props, query and currentPage, are passed to the fetchFilteredInvoices() function which returns the invoices that match the query

With these changes in place, go ahead and test it out. If you search for a term, you'll update the URL, which will send a new request to the server, data will be fetched on the server, and only the invoices that match your query will be returned.

When to use the useSearchParams() hook vs. the searchParams prop?

You might have noticed you used two different ways to extract search params. Whether you use one or the other depends on whether you're working on the client or the server.

`<Search>` is a Client Component, so you used the useSearchParams() hook to access the params from the client.
`<Table>` is a Server Component that fetches its own data, so you can pass the searchParams prop from the page to the component.
As a general rule, if you want to read the params from the client, use the useSearchParams() hook as this avoids having to go back to the server.

## Best practice: Debouncing
Congratulations! You've implemented search with Next.js! But there's something you can do to optimize it.

Inside your handleSearch function, add the following console.log:

You're updating the URL on every keystroke, and therefore querying your database on every keystroke! This isn't a problem as our application is small, but imagine if your application had thousands of users, each sending a new request to your database on each keystroke.

Debouncing is a programming practice that limits the rate at which a function can fire. In our case, you only want to query the database when the user has stopped typing.

How Debouncing Works:

Trigger Event: When an event that should be debounced (like a keystroke in the search box) occurs, a timer starts.
Wait: If a new event occurs before the timer expires, the timer is reset.
Execution: If the timer reaches the end of its countdown, the debounced function is executed.

## Adding pagination
After introducing the search feature, you'll notice the table displays only 6 invoices at a time. This is because the fetchFilteredInvoices() function in data.ts returns a maximum of 6 invoices per page.

Adding pagination allows users to navigate through the different pages to view all the invoices. Let's see how you can implement pagination using URL params, just like you did with search.

Navigate to the `<Pagination/>` component and you'll notice that it's a Client Component. You don't want to fetch data on the client as this would expose your database secrets (remember, you're not using an API layer). Instead, you can fetch the data on the server, and pass it to the component as a prop.

In /dashboard/invoices/page.tsx, import a new function called fetchInvoicesPages and pass the query from searchParams as an argument:

fetchInvoicesPages returns the total number of pages based on the search query. For example, if there are 12 invoices that match the search query, and each page displays 6 invoices, then the total number of pages would be 2.

Next, pass the totalPages prop to the `<Pagination/>` component:

Navigate to the `<Pagination/>` component and import the usePathname and useSearchParams hooks. We will use this to get the current page and set the new page. Make sure to also uncomment the code in this component. Your application will break temporarily as you haven't implemented the `<Pagination/>` logic yet. Let's do that now!

Here's a breakdown of what's happening:

createPageURL creates an instance of the current search parameters.
Then, it updates the "page" parameter to the provided page number.
Finally, it constructs the full URL using the pathname and updated search parameters.
The rest of the `<Pagination>` component deals with styling and different states (first, last, active, disabled, etc). We won't go into detail for this course, but feel free to look through the code to see where createPageURL is being called.

Finally, when the user types a new search query, you want to reset the page number to 1. You can do this by updating the handleSearch function in your `<Search>` component:

# 12: Mutating Data

## In this chapter...

Here are the topics we’ll cover

- What React Server Actions are and how to use them to mutate data.

- How to work with forms and Server Components.

- Best practices for working with the native formData object, including type validation.

- How to revalidate the client cache using the revalidatePath API.

- How to create dynamic route segments with specific IDs.


## What are Server Actions?
React Server Actions allow you to run asynchronous code directly on the server. They eliminate the need to create API endpoints to mutate your data. Instead, you write asynchronous functions that execute on the server and can be invoked from your Client or Server Components.

Security is a top priority for web applications, as they can be vulnerable to various threats. This is where Server Actions come in. They offer an effective security solution, protecting against different types of attacks, securing your data, and ensuring authorized access. Server Actions achieve this through techniques like POST requests, encrypted closures, strict input checks, error message hashing, and host restrictions, all working together to significantly enhance your app's safety.


## Using forms with Server Actions
In React, you can use the action attribute in the <form> element to invoke actions. The action will automatically receive the native FormData object, containing the captured data.

```tsx
// Server Component
export default function Page() {
  // Action
  async function create(formData: FormData) {
    'use server';
 
    // Logic to mutate data...
  }
 
  // Invoke the action using the "action" attribute
  return <form action={create}>...</form>;
}
```

## Next.js with Server Actions
Server Actions are also deeply integrated with Next.js caching. When a form is submitted through a Server Action, not only can you use the action to mutate data, but you can also revalidate the associated cache using APIs like revalidatePath and revalidateTag.

## Creating an invoice
Here are the steps you'll take to create a new invoice:

1. Create a form to capture the user's input.
2. Create a Server Action and invoke it from the form.
3. Inside your Server Action, extract the data from the formData object.
4. Validate and prepare the data to be inserted into your database.
5. Insert the data and handle any errors.
6. Revalidate the cache and redirect the user back to invoices page.

1. Create a new route and form
To start, inside the /invoices folder, add a new route segment called /create with a page.tsx file:

`/dashboard/invoices/create/page.tsx`
```tsx
import Form from '@/app/ui/invoices/create-form';
import Breadcrumbs from '@/app/ui/invoices/breadcrumbs';
import { fetchCustomers } from '@/app/lib/data';
 
export default async function Page() {
  const customers = await fetchCustomers();
 
  return (
    <main>
      <Breadcrumbs
        breadcrumbs={[
          { label: 'Invoices', href: '/dashboard/invoices' },
          {
            label: 'Create Invoice',
            href: '/dashboard/invoices/create',
            active: true,
          },
        ]}
      />
      <Form customers={customers} />
    </main>
  );
}
```

2. Create a Server Action
Great, now let's create a Server Action that is going to be called when the form is submitted.

Navigate to your lib directory and create a new file named actions.ts. At the top of this file, add the React use server directive:

`/app/lib/actions.ts`
```tsx
'use server';
 
export async function createInvoice(formData: FormData) {}
```

Good to know: In HTML, you'd pass a URL to the action attribute. This URL would be the destination where your form data should be submitted (usually an API endpoint).

However, in React, the action attribute is considered a special prop - meaning React builds on top of it to allow actions to be invoked.

Behind the scenes, Server Actions create a POST API endpoint. This is why you don't need to create API endpoints manually when using Server Actions.

3. Extract the data from formData
Back in your actions.ts file, you'll need to extract the values of formData, there are a couple of methods you can use. For this example, let's use the .get(name) method.

`/app/lib/actions.ts`
```tsx
'use server';
 
export async function createInvoice(formData: FormData) {
  const rawFormData = {
    customerId: formData.get('customerId'),
    amount: formData.get('amount'),
    status: formData.get('status'),
  };
  // Test it out:
  console.log(rawFormData);
}
```

Tip: If you're working with forms that have many fields, you may want to consider using the entries() method with JavaScript's Object.fromEntries(). For example:

```tsx
const rawFormData = Object.fromEntries(formData.entries())
```

4. Validate and prepare the data
Before sending the form data to your database, you want to ensure it's in the correct format and with the correct types. If you remember from earlier in the course, your invoices table expects data in the following format:

`/app/lib/definitions.ts`
```tsx
export type Invoice = {
  id: string; // Will be created on the database
  customer_id: string;
  amount: number; // Stored in cents
  status: 'pending' | 'paid';
  date: string;
};
```

Type validation and coercion
It's important to validate that the data from your form aligns with the expected types in your database. For instance, if you add a console.log inside your action:


`console.log(typeof rawFormData.amount);`
You'll notice that amount is of type string and not number. This is because input elements with type="number" actually return a string, not a number!

To handle type validation, you have a few options. While you can manually validate types, using a type validation library can save you time and effort. For your example, we'll use Zod, a TypeScript-first validation library that can simplify this task for you.

In your actions.ts file, import Zod and define a schema that matches the shape of your form object. This schema will validate the formData before saving it to a database.

`/app/lib/actions.ts`
```tsx
'use server';
 
import { z } from 'zod';
 
const FormSchema = z.object({
  id: z.string(),
  customerId: z.string(),
  amount: z.coerce.number(),
  status: z.enum(['pending', 'paid']),
  date: z.string(),
});
 
const CreateInvoice = FormSchema.omit({ id: true, date: true });
 
export async function createInvoice(formData: FormData) {
  // ...
}
```

6. Revalidate and redirect
Next.js has a Client-side Router Cache that stores the route segments in the user's browser for a time. Along with prefetching, this cache ensures that users can quickly navigate between routes while reducing the number of requests made to the server.

Since you're updating the data displayed in the invoices route, you want to clear this cache and trigger a new request to the server. You can do this with the revalidatePath function from Next.js:

Once the database has been updated, the /dashboard/invoices path will be revalidated, and fresh data will be fetched from the server.

At this point, you also want to redirect the user back to the /dashboard/invoices page. You can do this with the redirect function from Next.js:

`/app/lib/actions.ts`
```tsx
'use server';

import { z } from 'zod';
import { sql } from '@vercel/postgres';
import { revalidatePath } from 'next/cache';
import { redirect } from 'next/navigation';

const FormSchema = z.object({
    id: z.string(),
    customerId: z.string(),
    amount: z.coerce.number(),
    status: z.enum(['pending', 'paid']),
    date: z.string(),
});

const CreateInvoice = FormSchema.omit({ id: true, date: true });

export async function createInvoice(formData: FormData) {
    const { customerId, amount, status } = CreateInvoice.parse({
        customerId: formData.get('customerId'),
        amount: formData.get('amount'),
        status: formData.get('status'),
    });
    const amountInCents = amount * 100;
    const date = new Date().toISOString().split('T')[0];
    await sql`
      INSERT INTO invoices (customer_id, amount, status, date)
      VALUES (${customerId}, ${amountInCents}, ${status}, ${date})
    `;

    revalidatePath('/dashboard/invoices');
    redirect('/dashboard/invoices');
}

```

# 13: Handling Errors

In this chapter...

Here are the topics we’ll cover

- How to use the special error.tsx file to catch errors in your route segments, and show a fallback UI to the user.

- How to use the notFound function and not-found file to handle 404 errors (for resources that don’t exist).

# 14: Improving Accessibility
