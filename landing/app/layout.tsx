import type { Metadata } from "next";
import "./globals.css";

export const metadata: Metadata = {
  title: "ARTILIA — Sistem Inspeksi Cacat Visual & Manajemen Lab Berbasis Edge CV (PKM-KC PIMNAS 38)",
  description: "Karya Cipta PKM-KC: Sistem Cerdas Manajemen Inventaris Laboratorium dan Inspeksi Keausan Alat Presisi Berbasis Edge Computer Vision dengan K3 Safety Interlock.",
  keywords: "PKM-KC, PIMNAS 38, Edge Computer Vision, Sobel Edge Detection, Laboratorium Presisi, K3 Safety, Inventaris Alat",
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="id" className="scroll-smooth">
      <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
        <link
          href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&family=Outfit:wght@500;600;700;800;900&display=swap"
          rel="stylesheet"
        />
      </head>
      <body className="antialiased selection:bg-indigo-500/30 selection:text-indigo-200">{children}</body>
    </html>
  );
}