import { cn } from '@/lib/utils';

export default function InputSection({
    className,
    children,
}: React.ComponentProps<'div'>) {
    return (
        <div className={cn('grid grid-cols-12 items-center gap-2', className)}>
            {children}
        </div>
    );
}
