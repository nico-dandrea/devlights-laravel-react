// DocumentationLink.js
import React from 'react';

function DocumentationLink() {
  return (
    <a
      href="https://laravel.com/docs"
      className="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
    >
      <DocumentationLinkContent />
      <DocumentationLinkArrow />
    </a>
  );
}

function DocumentationLinkContent() {
  return (
    <div>
      <div className="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          strokeWidth="1.5"
          className="w-7 h-7 stroke-red-500"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"
          />
        </svg>
      </div>

      <h2 className="mt-6 text-xl font-semibold text-gray-900 dark:text-white">
        Documentation
      </h2>

      <p className="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
        Laravel has wonderful documentation covering every aspect of the framework.
        Whether you are a newcomer or have prior experience with Laravel, we recommend
        reading our documentation from beginning to end.
      </p>
    </div>
  );
}

function DocumentationLinkArrow() {
  return (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      strokeWidth="1.5"
      className="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6"
      >
        <path
          strokeLinecap="round"
        strokeLinejoin="round"
        d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
      />
    </svg>
  );
}

export default DocumentationLink;
