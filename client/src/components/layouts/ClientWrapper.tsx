// ✅ app/ClientWrapper.tsx
'use client';

import { ThemeProvider } from '@material-tailwind/react';

export default function ClientWrapper({
  children,
}: {
  children: React.ReactNode;
}) {
  return <ThemeProvider>{children}</ThemeProvider>;
}
