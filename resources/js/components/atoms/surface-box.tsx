import { cn } from '@/lib/utils';

export default function SurfaceBox({
    className,
    children,
}: React.ComponentProps<'div'>) {
    return (
        <div
            className={cn(
                'bg-surface-nested/40 rounded-xl border border-secondary/10 p-3',
                className,
            )}
        >
            {children}
        </div>
    );
}
