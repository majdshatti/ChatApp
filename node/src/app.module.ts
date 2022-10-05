import { Module } from '@nestjs/common';
import { ChatGeteway } from './chat/chat.geteway';

@Module({
  imports: [],
  controllers: [],
  providers: [ChatGeteway],
})
export class AppModule {}
