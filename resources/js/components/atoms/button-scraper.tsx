import { Pause } from 'lucide-react';

type Scraper = {
    id: number;
    name: string;
    status: number;
    url: string;
};

export function ButtonScraper({
    scraper,
    isActive,
    ...props
}: React.ComponentProps<'button'> & {
    scraper: Scraper;
    isActive: boolean;
}) {
    return (
        <button
            className={`group relative flex w-full cursor-pointer items-center justify-between rounded-xl border p-3 text-left transition-all duration-200 ${
                isActive
                    ? 'text-text-main border-primary/60 bg-linear-to-r from-slate-50 to-primary/40'
                    : 'bg-surface-nested/40 hover:bg-surface-nested/80 border-secondary/5 text-secondary hover:border-secondary/20'
            }`}
            {...props}
        >
            {/* Left Side: Name and Status Text */}
            <div className="flex min-w-0 flex-col">
                <span
                    className={`truncate text-sm font-medium ${isActive ? 'text-text-main' : 'text-text-main/90'}`}
                >
                    {scraper.name}
                </span>
                <span className="mt-0.5 text-[11px] font-normal capitalize opacity-60">
                    {getStatus(scraper.status)}
                </span>
            </div>
            <div className="flex shrink-0 items-center space-x-2">
                {renderStatusIndicator(scraper.status)}
            </div>
        </button>
    );
}

const renderStatusIndicator = (status: number) => {
    switch (status) {
        case 0:
            return (
                <span className="relative flex h-2.5 w-2.5">
                    <span className="bg-success absolute inline-flex h-full w-full animate-ping rounded-full opacity-75"></span>
                    <span className="bg-success relative inline-flex h-2.5 w-2.5 rounded-full"></span>
                </span>
            );
        case 1:
            return <Pause className="text-warning h-3.5 w-3.5" />;
        default:
            return <div className="h-2 w-2 rounded-full bg-secondary/40" />;
    }
};

const getStatus = (status: number) => {
    switch (status) {
        case 0:
            return 'Active';
        case 1:
            return 'Paused';
        default:
            return 'Idle';
    }
};
