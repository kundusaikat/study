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