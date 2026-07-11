import { cn } from '@/lib/utils';

export default function InputLabelSection({
    className,
    children,
}: React.ComponentProps<'div'>) {
    return (
        <div
            className={cn(
                'grid grid-cols-12 px-1 text-[10px] font-medium opacity-60',
                className,
            )}
        >
            {children}
        </div>
    );
}
